<?php

namespace AV_Core\Http\Controllers;

use AV_Core\Models\DataUser;
use AV_Core\Models\User;
use AV_Core\Models\Data;
use Auth;
use Illuminate\Http\Request;
use App\Services\SocialAccountService;
use Illuminate\Support\Facades\Log;
use Socialite;
use DB;
use JWTAuth;
use JWTAuthException;
use JWTFactory;
use Role;
use Carbon\Carbon;
use Illuminate\Cookie\CookieJar;
use Session;
use Goutte\Client;
use Storage;
use File;
class LoginController extends Controller
{
    /**
     * @param $social
     * @return mixed
     */
    public function redirect($social, CookieJar $cookieJar)
    {
        Session::flash('ref', request('ref'));
        // $p = $cookieJar->queue(cookie('ref',request('ref'),true,9999999));

        return Socialite::driver($social)->redirect();
    }

    /**
     * @param $social
     * @return \Illuminate\Http\JsonResponse
     */
    public function callback($social)
    {
        if ($social !== 'facebook') {
            return response()->json(['invalid_facebook'], 401);
        }
        $user = Socialite::driver($social)->user();
        $authUser = $this->findOrCreateUser($user);
        Auth::login($authUser, true);
        return redirect()->route('admin.home');
    }

    private function findOrCreateUser($facebookUser){
        $seller   = Session::get('ref');
        $authUser = User::where('uid', $facebookUser->id)
                        ->orWhere('email', $facebookUser->email)->first();

        if($authUser){
            User::where('id', $authUser->id)->update([
                'name'          => $facebookUser->name,
                'email'         => $facebookUser->email,
                'uid'           => $facebookUser->id,
                'token'         => $facebookUser->token,
                'avatar'        => $facebookUser->avatar,
                'lastlogindate' => Carbon::now()
            ]);
            return $authUser;
        }
        return User::create([
            'name'          => $facebookUser->name,
            'password'      => bcrypt($facebookUser->token),
            'email'         => $facebookUser->email,
            'uid'           => $facebookUser->id,
            'token'         => $facebookUser->token,
            'avatar'        => $facebookUser->avatar,
            'lastlogindate' => Carbon::now(),
            'seller'        => $seller,
        ]);
    }

    public function verifyPhone(Request $request){
        $app_id = '1931115790243808';
        $secret = 'dc66b9765680a8954a2515d2e18aa262';
        $version = 'v1.1'; // 'v1.1' for example

        // Method to send Get request to url
        function doCurl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $data;
        }

        // // Exchange authorization code for access token
        $token_exchange_url = 'https://graph.accountkit.com/'.$version.'/access_token?'.
        'grant_type=authorization_code'.
        '&code='.$request->code.
        "&access_token=AA|$app_id|$secret";
        $data = doCurl($token_exchange_url);
        $user_access_token = $data['access_token'];
        $refresh_interval = $data['token_refresh_interval_sec'];

        // Get Account Kit information
        $me_endpoint_url = 'https://graph.accountkit.com/'.$version.'/me?'.
        'access_token='.$user_access_token;
        $data = doCurl($me_endpoint_url);
        $phone = isset($data['phone']) ? $data['phone']['number'] : '';
        // Updade
        $user_id = User::where('id', Auth::id())->update(['phone' => $phone]);

        return response()->json([
            'status' => 200,
            'msg' => 'Cap nhat phone thanh cong'
        ]);

    }

    public function loginFb(){
        $user_access_token = request('accessToken');
        $graph_url = 'https://graph.facebook.com/me?fields=email,name,picture&access_token='.$user_access_token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $graph_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($output);
        // echo "<pre>";
        // var_dump($result->id);
        $uid  = ['uid' => $result->id];
        $data   = [
            'uid'           => $result->id,
            'token'         => $user_access_token,
            'name'          => $result->name,
            'password'      => bcrypt($user_access_token),
            'avatar'        => $result->picture->data->url,
            'lastlogindate' => Carbon::now(),
            // 'email'         => $result->email,
        ];

        $user = User::updateOrCreate($uid, $data);

        // Login User for Admin web
        Auth::login($user, true);

        $credentials = ['uid' => $user->uid, 'password' => $user->password];
        $customClaims = ['sub' => $user->uid];
        $authCode     = NULL;

        try {
            if (!$authCode = JWTAuth::fromUser($user, $customClaims)) {
                return response()->json(['invalid_email_or_password'], 401);
            }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }

        // Update
        $user->update(['authcode' => $authCode]);

        // LOG
        Log::debug("Xác thực tài khoản khách hàng thành công: \nemail: ". $user->email . "\nuid: ". $user->uid);

        return response()->json([
            'status' => 200,
            'token'  => $authCode
        ]);
    }

    /**
     * @param $request
     * @return bool
     */
    private function _checkAuthCode($request)
    {
        $checkAuthcode = User::where('authcode', $request->token)->first();
        if ($checkAuthcode) {
            return $checkAuthcode;
        }
        return FALSE;
    }

      /**
    * @param $checkAuthcode
    * @return bool
     */
    private function _checkExpiredUser($checkAuthcode){
        if($checkAuthcode->usertype == '1'){
            $now = Carbon::now();
            return ($checkAuthcode->expired < $now) ? 'Thời gian sử dụng đã hết' : FALSE;
        }else{
            return ($checkAuthcode->profit >= $checkAuthcode->credit) ? 'Số lần dùng thử đã hết' : FALSE;
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserInfo(Request $request)
    {
        // Xác thực user khách hàng
        $checkAuthcode = $this->_checkAuthCode($request);
        if ($checkAuthcode) {
            Log::debug('Xác thực thông tin khách hàng thành công: user_id: ' . $checkAuthcode->id);
            return response()->json([
                'status' => 200,
                'user'   => $checkAuthcode,
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMemberInfo(Request $request)
    {
        // return $request->name;
        Log::debug(json_encode('Get Member Info'));
        // Xác thực user khách hàng
        $checkAuthcode = $this->_checkAuthCode($request);
        if ($checkAuthcode) {
            // kiểm tra xác thực số điện thoại
            if(!empty($checkAuthcode->phone)){
                // kiểm tra role của user
                $checkRole = $this->_checkExpiredUser($checkAuthcode);
                if(!$checkRole){
                    $dataModel = new Data();
                    $checkUID = $dataModel->where('uid', $request->uid)->first();
                    if ($checkUID) {
                        $link = "https://www.facebook.com/".$checkUID->uid;
                        $client = new Client();
                        $client->setHeader('User-Agent', "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36");
                        $crawler = $client->request('GET', $link);
                        $location = '';
                        $count = $crawler->filter('._2iel._50f7')->count();
                        if($count != 0){
                            $location = $crawler->filter('._2iel._50f7')->eq(0)->text();
                        }
                        // Insert đến danh sách thông tin khách hàng quét trong table data_user
                        $dataUser = new DataUser();
                        $result = $dataUser::updateOrCreate([
                            'user_id'   => $checkAuthcode->id,
                            'data_id'   => $checkUID->id,
                            'name'      => $request->name,
                            'phone'     => $checkUID->phone,
                            'link'      => "https://www.facebook.com/".$checkUID->uid,
                            'location'  => $location,
                        ]);

                        if ($result) {
                            if($checkAuthcode->usertype == 0){
                                $profit = $checkAuthcode->profit + 1;
                                $checkAuthcode->update(['profit' => $profit ]);
                            }
                            Log::debug(json_encode('Lay thong tin tai khoang FB thanh cong: ' . $checkUID));
                            return response()->json([
                                'status'  => 200,
                                'message' => $checkUID->phone
                            ]);
                        }
                    }
                    return response()->json([
                        'status'  => 201,
                        'message' => 'Không tìm được thông tin user'
                    ]);
                }else{
                    return response()->json([
                        'status' => 401,
                        'message' => $checkRole
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 401,
                    'message' => 'Bạn chưa cập nhật số điện thoại.'
                ]);
            }

        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Hết thời hạn đăng nhập. Vui lòng đăng nhập lại.'
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListScan(Request $request)
    {
        // Xác thực user khách hàng
        $checkAuthcode = $this->_checkAuthCode($request);
        if ($checkAuthcode) {

            $data = DataUser::where('user_id', $checkAuthcode->id)->orderBy('created_at', 'desc')->limit(5)->get();
            if ($data) {
                // Log
                Log::debug('Get data thanh cong: ' . json_encode($data));

                return response()->json([
                    'status' => 200,
                    'data'   => $data
                ]);
            }
        }

        // Log
        Log::debug('Loi get data');

        return response()->json(['status' => 400]);
    }

    public function test1(){

        // return view('av_core::chinhsach');

        // $file = request('fileToUpload');
        // $url =  $file->move('public/upload', $file->getClientOriginalName());
        // $contents = File::get($url);
        // $contents = explode("\n",$contents);
        // foreach(array_chunk($contents, 500)  as $chunk){
        //     $data = DB::table('data')
        //                 ->whereIn('uid', $chunk)
        //                 ->get();
        //     foreach($data as $item){
        //         Storage::append('file.txt',$item->phone);
        //     }
        // }
        // Storage::put('file.txt', $data);

        $link = "https://vi-vn.facebook.com/100008570375606";
        $client = new Client();
        $client->setHeader('User-Agent', "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36");
        $crawler = $client->request('GET', $link);
        return $crawler->filter('._2iel._50f7')->eq(0)->text();
        // $price = $this->replace(',',$crawler->filter('.pad5')->eq(6)->text());
    }
}
