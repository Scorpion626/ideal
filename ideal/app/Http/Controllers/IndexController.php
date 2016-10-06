<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\UserModel ;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use \Illuminate\Support\Facades\File as File;
class IndexController extends Controller 
{
        private function checkPass($password)
        {
            $length = strlen($password);
            for($i = 0;$i < $length; $i++)
            {
                if(is_numeric($password[$i]))
                {
                    return true;
                }
            }
            return false;
        }
	public function index()
	{            
             if(session()->has('login'))
             {
                 return redirect()->action('IndexController@main');
             }
             
            $title = 'Главная';
            return view('ideal.index',['title'=>$title]);
        }
        public function people(Request $request)
        {
            $userModel = new UserModel();
            $answer = $userModel->getPopularUsers();
            return $answer;
        }
        public function peoplePop(Request $request)
        {
            $userModel = new UserModel();
            $id = session('user_id');
            $answer = $userModel->getPopularUsersAuth($id);
            return $answer;
        }
        public function plus(Request $request)
        {
            if(!session()->has('login'))
            {
                return   redirect('http://ideal/');
            }
            $userModel = new UserModel();
            $userTo = $request['user_id'];
            $userFrom = session('user_id');
            if ($userModel->checkKarmaChange($userTo, $userFrom, 1))
            {
                if($userTo != $userFrom)
                {   
                    $ar = $userModel->karmaPlus($userFrom, $userTo);
                    return 'true';
                }
            }
            return 'false';
         
        }
        public function minus(Request $request)
        {
            if(!session()->has('login'))
            {
               return   redirect('http://ideal/');
            }
            
            $userModel = new UserModel();
            $userTo = $request['user_id'];
            $userFrom = session('user_id');
            if ($userModel->checkKarmaChange($userTo, $userFrom, 0))
            {
                if($userTo != $userFrom)
                {
                 $userModel->karmaMinus($userFrom, $userTo);
                }
                
            }
         }
        
	public function enter(Request $request)
	{
             if(session()->has('login'))
             {
                 return redirect()->action('IndexController@main');
             }
            if(isset($_POST['submit']))
            {
                $user = new UserModel();
                $this->validate($request,[
                    'login'     =>'required|min:4|max:15',
                    'password'  =>'required|min:5|max:25',
                    'captcha'   =>'required|min:6|confirmed']);
                $login = $request['login'];
                $password = $request['password'];
                $login = $user->normalize($login);
                $password = $user->normalize($password);
                $uEnter = $user->enter($login, $password);
                if($uEnter == NULL)
                {
                    $title = 'Вход';
                    $letters = 'ABCDEFGKIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
                    $captchaLength = 6;
                    $captcha = '';
                    for($i = 0; $i < $captchaLength; $i++)
                    {
                        $captcha .= $letters[mt_rand(0, 61)];
                    }
                    return view('ideal.enter',['title'=>'Вход','captcha'=>$captcha,'errorEnt'=>'Не верный логин/пароль']);
                }
                else
                {
                    session(['login'=>$uEnter->login,'user_id'=>$uEnter->user_id]);
                    return redirect()->action('IndexController@main');
                }
            }
            else
            {
               $title = 'Вход';
               $letters = 'ABCDEFGKIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
               $captchaLength = 6;
               $captcha = '';
               for($i = 0; $i < $captchaLength; $i++)
               {
                   $captcha .= $letters[mt_rand(0, 61)];
               }
                return view('ideal.enter',['title'=>$title,'captcha'=>$captcha]);
            }
            
	}

	
	public function registration(Request $request)
	{
            if(session()->has('login'))
             {
                return redirect()->action('IndexController@main');
             }
             
             $userModel = new UserModel;
             if (isset($_POST['submit']))
            {
               $this->validate($request,['login'=>'alpha_num|required|min:4|max:15|unique:users',
                   'password'=>'required|min:5|max:25|confirmed',
                   'date'=>'required|date',
                   'foto'=>'max:5120']);
                $login = $request['login'];
                $password = $request['password'];
                $date = $request['date'];
                $sex = $request['sex'];
                if(!$this->checkPass($password))
                {
                    return view('ideal.registration',['title'=>'Регистрация',
                                'errorPass'=>'Поле должно содержать хотя бы 1 цифру']);
                }
                else
                {
              
                    if(!file_exists('./foto/'.$login))
                     {
                        mkdir('./foto/'.$login);
                     }
                    if($request->file('foto') == NULL)
                     {
                       $foto = File::get('./foto/default/default.jpg');
                       Image::configure(array('driver' => 'imagick'));
                       $img = Image::make($foto)->resize(50, 50);
                       $fullpath = './foto/'.$login.'/default.jpg';
                        $img->save($fullpath);
                     }
                     else 
                     {
                        $foto = $request->file('foto');
                        $format = $foto->getClientOriginalExtension();
                        if($format == "jpg" || $format == "png" || 
                            $format == "jpeg"|| $format == "gif")
                        {
                            $name = $foto->getClientOriginalName();
                            $name = $userModel->transl($name);
                            Image::configure(array('driver' => 'imagick'));
                            $img = Image::make($foto)->resize(50, 50);
                            $fullpath = './foto/'.$login.'/'.$name;
                            $img->save($fullpath);
                        }
                        else
                        {
                            return view('ideal.registration',['title'=>'Регистрация',
                                'errorFoto'=>'Не верный формат изображения.<br>'
                                . 'Изображение может иметь форматы: <strong>.jpg, .jpeg, .png, .gif</strong>']);
                            
                        }
                    }
                    $user_id = $userModel->addUser($login,$password,$fullpath,$date,$sex);
                    session(['login'=>$login,'user_id'=>$user_id]);
                    return redirect()->action('IndexController@main');
                }
            }
            else
            {
		$title = 'Регистрация';
                $data = ['title'=>$title];
                if(isset($_GET['msg']))
                {
                    $msg = 'Зарегистрируйтесь или войдите в систему, для того чтобы оценить карму';
                    $data['msg']= $msg;
                }

                return view('ideal.registration',$data);
            }
	}
        public function main()
        {   
            
            if(!session()->has('login'))
            {
               return   redirect('http://ideal/');
            }
            $userModel = new UserModel();
            $fotoKarma = $userModel->getFotoKarma(session('user_id')) ;
            return view('ideal.auth.main',['title'=>'Главная',
                'foto'=>$fotoKarma['foto'],
                'karma'=>$fotoKarma['karma']]);
                       
        }
        
        public function exitZ()
        {
            session()->flush();
            return  redirect()->action('IndexController@index');
        }
        
        public function userInfo(Request $request)
        {   
            $userModel = new UserModel;
            $user_id = $userModel->normalize($_GET['user_id']);
            if(!session()->has('login'))
            {
                $view = 'ideal.Info';
                $story = $userModel->getStory($user_id);
                $count = count($story);
                $plus = "<div class='registrationGo' ><img src='./foto/default/plus.jpg'></div>";
                $minus = "<div class= 'registrationGo'><img src='./foto/default/minus.png'><br><br><br></div>";
                $login = $userModel->getUser($user_id);
                $allComments = $userModel->getComments($user_id);
                if($allComments == NULL)
                {
                    $allComments = NULL;
                }
                $data2 = ([
                        'title'     =>  'Информация о пользователе',
                        'login'     =>  $login['login'],
                        'fotoUser'  =>  $login['foto'],
                        'karmaUser' =>  $login['karma'],
                        'userId'    =>  $user_id,
                        'plus'      =>  $plus,
                        'minus'     =>  $minus,
                        'story'     =>  $story,
                        'comments'  =>  $allComments,
                        'extends'   =>  'ideal/template']);
                return view($view,$data2);
            }
            else
            {
               
                $id = session('user_id');
                $fotoKarma = $userModel->getFotoKarma($id) ;
                if (isset($_POST['add']))
                {
                    $comment = $request['comment'];
                    $comment = htmlspecialchars($comment);
                    $userModel->AddComment($id, $comment, $user_id);
                    
                }    
                $data = array();
                if($user_id == $id)
                {

                    $view = 'ideal.auth.myInfo';
                    $story = $userModel->getStory($user_id);

                }
                else
                {
                    $view = 'ideal.auth.Info';
                    $story = $userModel->getStory($user_id);
                    $count = count($story);
                    $plus = "<div class='plusUser' id='".$user_id."'><img src='./foto/default/plus.jpg'></div>";
                    $minus = "<div class= 'minusUser' id='".$user_id."'><img src='./foto/default/minus.png'><br><br><br></div>";
                    for($i = 0; $i < $count; $i++)
                    {
                        if($story[$i]['id_userFrom'] == $id)
                        {
                            if($story[$i]['Karma_change']== '-')
                            {
                                $minus = "<div  ><img src='./foto/default/minusOn.png'><br><br><br></div>";
                            }
                            elseif($story[$i]['Karma_change'] == '+')
                            {
                                $plus = "<div  ><img src='./foto/default/plusOn.jpg'></div>";
                            }
                        }
                    }
                    $login = $userModel->getUser($user_id);
                    $data2 = ([
                        'login'     =>  $login['login'],
                        'fotoUser'  =>  $login['foto'],
                        'karmaUser' =>  $login['karma'],
                        'userId'    =>  $user_id,
                        'plus'      =>  $plus,
                        'minus'     =>  $minus,
                        'extends'   =>  'ideal/auth/template']);
                }
                $allComments = $userModel->getComments($user_id);
                if($allComments == NULL)
                {
                    $allComments = NULL;
                }
                $data = (['title'=>'Информация о пользователе',
                        'foto'      =>  $fotoKarma['foto'],
                        'karma'     =>  $fotoKarma['karma'],
                        'story'     =>  $story,
                        'comments'  =>  $allComments]);
                if (isset($data2))
                {
                    $data =array_merge($data, $data2);
                }

                return view($view,$data);
            }
        }
        public function change(Request $request)
        {
            if(!session()->has('login'))
            {
               return   redirect('http://ideal/');
            }
            $userModel = new UserModel;  
            $id = session('user_id');
            $fotoKarma = $userModel->getFotoKarma($id) ;
            if(!isset($_POST['submit']))
            {
              
                $sex = $userModel->getSex($id);
                if ($sex == 0)
                {
                    $sexName = 'Мужской';
                    $unCheck = 'Женский';
                    $unCheckSex = 1;
                }
                else
                {
                    $sexName = 'Женский';
                    $unCheck = 'Мужской';
                    $unCheckSex = 0;
                }
                return view('ideal.auth.change',['title'=>'Смена информации',
                   'foto'=>$fotoKarma['foto'],
                   'karma'=>$fotoKarma['karma'],
                   'sex'=>$sex,
                   'sexName'=>$sexName,
                   'unCheck'=>$unCheck,
                   'unCheckSex'=>$unCheckSex]);
            }
            else
            {
                if($request->file('foto') != NULL)
                {
                    
                    $foto = $request->file('foto');
                   
                    $sex = $request['sex'];
                    $format = $foto->getClientOriginalExtension();
                    if($format == "jpg" || $format == "png" || 
                        $format == "jpeg"|| $format == "gif")
                   {
                            $oldPath = $userModel->getFoto($id);
                            File::delete($oldPath);
                            $name = $foto->getClientOriginalName();
                            $name = $userModel->transl($name);
                            Image::configure(array('driver' => 'imagick'));
                            $img = Image::make($foto)->resize(50, 50);
                            $login = session('login');
                            $fullpath = './foto/'.$login.'/'.$name;
                            $img->save($fullpath);
                            $userModel->updateFoto($id, $fullpath,$sex);
                           $fotoKarma['foto'] = $fullpath;
                    }
                    else
                   {
                        $fotoKarma = $userModel->getFotoKarma($id) ;
                        $sex = $userModel->getSex($id);
                        if ($sex == 0)
                        {
                            $sexName = 'Мужской';
                            $unCheck = 'Женский';
                            $unCheckSex = 1;
                        }
                        else
                        {
                            $sexName = 'Женский';
                            $unCheck = 'Мужской';
                            $unCheckSex = 0;
                        }
                        return view('ideal.auth.change',['title'=>'Смена информации',
                                   'foto'=>$fotoKarma['foto'],
                                   'karma'=>$fotoKarma['karma'],
                                   'sex'=>$sex,
                                   'sexName'=>$sexName,
                                   'unCheck'=>$unCheck,
                                   'unCheckSex'=>$unCheckSex,
                                'fotoErr'=>'Не верный формат изображения.<br>'
                                . 'Изображение может иметь форматы:'
                                . '<strong>.jpg, .jpeg, .png, .gif</strong>']);
                    }     
                }
                $sex = $request['sex'];
                $userModel->updateSex($id,$sex);
                return view('ideal.auth.success',['title'=>'Успех',
                   'foto'=>$fotoKarma['foto'],
                   'karma'=>$fotoKarma['karma']]);
            }
        }
}