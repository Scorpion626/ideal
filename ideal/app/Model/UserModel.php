<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class UserModel extends Model {
    public function addUser($login,$password,$foto,$dateBirth,$sex)//добавление пользователя
    {
        $login = htmlspecialchars($login);
        $password = htmlspecialchars($password);
        $password = md5($password);
        DB::table('users')->insert(['login'=>$login,'password'=>$password,'sex'=>$sex,
            'date_birth'=>$dateBirth,'foto'=>$foto]);
        $user = DB::table('users')->where('login','=',$login)->select('user_id')->first();
        DB::table('Karma')->insert(['id_user'=>$user->user_id]);
        return $user->user_id;
    }
    public function getUser($user_id)
    {
        $user_id = htmlspecialchars($user_id);
        $user = DB::table('users')->where('user_id','=',$user_id)->select('login')->first();
        $foto = DB::table('users')->where('user_id','=',$user_id)->select('foto')->first();
            $arr['foto']= $foto->foto;
            $karma = DB::table('Karma')->where('id_user','=',$user_id)->select('karma')->first();
            $arr['karma'] = $karma->karma;
            $arr['login'] = $user->login;
            return $arr;
    }

    public   function transl($st,$code='utf-8'){
        $st = mb_strtolower($st, $code);  
        $st = str_replace(array(  
        '?','!',',',':',';','*','(',')','{','}','%','#','№','@','$','^','-','+','/','\\','=','|','"','\'',  
        'а','б','в','г','д','е','ё','з','и','й','к',  
        'л','м','н','о','п','р','с','т','у','ф','х',  
        'ъ','ы','э',' ','ж','ц','ч','ш','щ','ь','ю','я'  
         ), array(  
        '','','','','','','','','','','','','','','','','','','','','','','','',/*remove bad chars*/  
        'a','b','v','g','d','e','e','z','i','y','k',  
        'l','m','n','o','p','r','s','t','u','f','h',  
        'j','i','e','_','zh','ts','ch','sh','shch',  
        '','yu','ya'  
            ), $st);  

        return $st;     
        }   
        
        public function enter($login, $password)
        {
            $login = htmlspecialchars($login);
            $password = htmlspecialchars($password);
            $password = md5($password);
            $user = DB::table('users')->where('login','=',$login)
                    ->where('password','=',$password)
                    ->select('login','user_id')->first();
            return $user;
        }
        
        public function normalize($text)
        {
            $text = str_replace("&","&nbsp;",$text);
            $text = str_replace(":", "&nbsp", $text);
            $text = str_replace('"',"&nbsp",$text);
            $text = str_replace("'", "&nbsp", $text);
            $text = str_replace('<',"&nbsp",$text);
            $text = str_replace('>', "&nbsp",$text);
            $text = str_replace('=', "&nbsp",$text);
            return $text;
        }
        
        public function getFotoKarma($user_id)
        {
            $user_id = htmlspecialchars($user_id);
            $foto = DB::table('users')->where('user_id','=',$user_id)->select('foto')->first();
            $arr['foto']= $foto->foto;
            $karma = DB::table('Karma')->where('id_user','=',$user_id)->select('karma')->first();
            $arr['karma'] = $karma->karma;
            return $arr;
        }
        
        public function getSex($id)
        {
            $id = htmlspecialchars($id);
            $sex = DB::table('users')->where('user_id','=',$id)->select('sex')->first();
            return $sex->sex;
        }
        
        public function getFoto($id)
        {
            $id = htmlspecialchars($id);
            $foto = DB::table('users')->where('user_id','=',$id)->select('foto')->first();
            return $foto->foto;
        }
        
        public function updateFoto($id,$path,$sex)
        {
             $id = htmlspecialchars($id);
            DB::table('users')->where('user_id','=',$id)->update(['foto'=>$path,'sex'=>$sex]);
        }
        
        public function updateSex($id,$sex)
        {
             $id = htmlspecialchars($id);
            DB::table('users')->where('user_id','=',$id)->update(['sex'=>$sex]);
        }
        
        public function getPopularUsers()
        {
            $popular = DB::table('Karma')->orderBy('karma','desk')->take(15)->get();
            $arr = array();
            $i=0;
            foreach($popular as $pop )
            {
                $arr[$i]['user_id'] = $pop->id_user;
                $arr[$i]['karma'] = $pop->karma;
                $fotoLogin = DB::table('users')->where('user_id','=',$arr[$i]['user_id'])
                        ->select('login','foto')->first();
                $arr[$i]['login'] = $fotoLogin->login;
                $arr[$i]['foto'] = $fotoLogin->foto;
                $i++;
            }
            return $arr;
        }
        
        public function karmaPlus($idFrom,$idTo)
        {
            $idFrom = htmlspecialchars($idFrom);
            $idTo = htmlspecialchars($idTo);
            $points = 1;
            $check = DB::table('KarmaStory')->where('id_user','=',$idTo)
                    ->where('id_userFrom','=',$idFrom)
                    ->select('Karma_change')->first();
            if ($check != NULL)
            {
                DB::table('KarmaStory')->where('id_user','=',$idTo)->where('id_userFrom','=',$idFrom)
                        ->delete();
                $points = 2;
            }
            $karma = DB::table('Karma')->where('id_user','=',$idTo)->select('karma')->first();
            $karmat = $karma->karma + $points;
            DB::table('Karma')->where('id_user','=',$idTo)->update(['karma'=>$karmat]);
            
            DB::table('KarmaStory')->insert(['id_user'=>$idTo,
                'id_userFrom'=>$idFrom,
                'Karma_change'=> 1]);
            return 'true';
        }
        
        public function karmaMinus($idFrom,$idTo)
        {
            $idFrom = htmlspecialchars($idFrom);
            $idTo = htmlspecialchars($idTo);
            $points = 1;
            $check = DB::table('KarmaStory')->where('id_user','=',$idTo)
                    ->where('id_userFrom','=',$idFrom)
                    ->select('Karma_change')->first();
            if ($check != NULL)
            {
                DB::table('KarmaStory')->where('id_user','=',$idTo)->where('id_userFrom','=',$idFrom)
                        ->delete();
                $points = 2;
            }
            $karma = DB::table('Karma')->where('id_user','=',$idTo)->select('karma')->first();
            $karmat = $karma->karma - $points;
            DB::table('Karma')->where('id_user','=',$idTo)->update(['karma'=>$karmat]);
            DB::table('KarmaStory')->insert(['id_user'=>$idTo,
                'id_userFrom'=>$idFrom,
                'Karma_change'=> 0]);
            return 'true';
        }
        
        public function getPopularUsersAuth($id)
        {
            $id = htmlspecialchars($id);
            $popular = DB::table('Karma')->orderBy('karma','desk')->take(15)->get();
            $arr = array();
            $i=0;
            foreach($popular as $pop )
            {
                $arr[$i]['user_id'] = $pop->id_user;
                $arr[$i]['karma'] = $pop->karma;
                $fotoLogin = DB::table('users')->where('user_id','=',$arr[$i]['user_id'])
                        ->select('login','foto')->first();
                $arr[$i]['login'] = $fotoLogin->login;
                $arr[$i]['foto'] = $fotoLogin->foto;
                
                $Karma = DB::table('KarmaStory')->where('id_userFrom','=',$id)
                        ->where('id_user','=',$arr[$i]['user_id'])
                        ->select('Karma_change')->first();
                if($Karma != NULL)
                {
                    $arr[$i]['Karma_change'] = $Karma->Karma_change;
                }
                else
                {
                    $arr[$i]['Karma_change'] = 'false';
                }
                
                $i++;
            }
            return $arr;
        }
        
        public function getStory($user_id)
        {
            $user_id = htmlspecialchars($user_id);
            $story = DB::table('KarmaStory')->where('id_user','=',$user_id)
                    ->orderBy('date','desk')
                    ->select('id_userFrom','Karma_change','date')->get();
            $arr = array();
            $i = 0; 
            foreach($story as $stor)
            {
                $arr[$i]['id_userFrom'] = $stor->id_userFrom;
                $arr[$i]['date'] = $stor->date;
                if ($stor->Karma_change == 1)
                {
                    $arr[$i]['Karma_change'] = '+';
                }
                else
                {
                    $arr[$i]['Karma_change'] = '-';
                }
                $login = DB::table('users')->where('user_id','=',$arr[$i]['id_userFrom'])
                        ->select('login','sex')->first();
                if($login->sex == 0)
                {
                    $arr[$i]['sex'] = 'поставил';
                }
                else
                {
                    $arr[$i]['sex'] = 'поставила';
                }
                $arr[$i]['loginStory'] = $login->login;
                
                $i++;
            }
            return $arr;
        }
        
        public function AddComment($idFrom,$comment,$idTo)
        {
            $comment = htmlspecialchars($comment);
            $idFrom = htmlspecialchars($idFrom);
            $idTo = htmlspecialchars($idTo);
            DB::table('Comments')->insert(['id_user'    => $idTo,
                'id_userFrom'   =>  $idFrom,
                'comment'       =>  $comment]);
        }
        
        public function getComments($id)
        {
            $id = htmlspecialchars($id);
            $comment = DB::table('Comments')->where('id_user','=',$id)->get();
            foreach ($comment as $com)
            {
                $login = DB::table('users')->where('user_id','=',$com->id_user)
                        ->select('login','sex')->first();
                $com->login = $login->login;
                if($login->sex == 0)
                {
                    $com->sex = "Написал";
                }
                else
                {
                    $com->sex = 'Написала';
                }
            }
            return $comment;
        }
        public function checkKarmaChange($userTo,$userFrom,$type)
        {
            $idFrom = htmlspecialchars($userFrom);
            $idTo = htmlspecialchars($userTo);
            $check = DB::table('KarmaStory')->where('id_user','=',$idTo)
                    ->where('id_userFrom','=',$idFrom)
                    ->select('Karma_change')->first();
            if($check->Karma_change == $type)
            {
                return false;
            }
            else
            {
                return true;
            }
        }
}
