<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\I18n\FrozenTime;
use Cake\Auth\DefaultPasswordHasher;

class UsersController extends AppController {

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['login', 'confirm', 'remember', 'resetPassword', 'signup', 'logout']);
        $user = $this->Auth->user();
        if($user){
            $user['confirmed_at'] = new FrozenTime($user['confirmed_at']);
            $user['reset_at'] = new FrozenTime($user['reset_at']);
            $usersTable = TableRegistry::get('Users');
            $user = $usersTable->newEntity($user);
            $this->set('user', $user);
        }
    }


	public function index(){

        $this->render('profil', 'standard');
	}

	function login(){
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $this->Flash->success('Content de vous revoir '.$this->Auth->user('nom').' '.$this->Auth->user('prenom'));
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Votre email ou mot de passe est incorrect.');
        }
    }


    function logout(){
        $user = $this->Auth->user();
        $usersTable = TableRegistry::get('Users');
        $user = $usersTable->newEntity($user);
        $this->Flash->set('À Bientôt '.$user->nom.' '.$user->prenom, ['element' => 'success']);
        return $this->redirect($this->Auth->logout());
    }

    function signup(){
          $usersTable = TableRegistry::get('Users');
          $new_user = $usersTable->newEntity();
          if($this->request->is('post')){
            if(empty($this->request->getData()['password']) || $this->request->getData()['password'] != $this->request->getData()['password_verify']){
                $this->Flash->set('Mots de passe différents !', ['element' => 'error']);
            }
            $usersTable = TableRegistry::get('Users');
            $exist_email = $usersTable->find()
                ->where(
                    [
                        'email' => $this->request->getData()['email'],
                    ]
                )
                ->limit(1)
                ->all();
            if(!$exist_email->isEmpty()){
                $this->Flash->error('Cette email existe déjà.');

            }
            $user = $usersTable->newEntity($this->request->getData());
            $filename = $this->request->getData()['picture']['name'];
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $good_ext = in_array($extension, ['png', 'jpg', 'jpeg']);
            if($good_ext && $filename != ''){
                $user->picture = $this->request->getData()["picture"]["name"];
                move_uploaded_file($this->request->getData()["picture"]["tmp_name"],"img/user/".$this->request->getData()["picture"]["name"]);
            }else{
                $this->Flash->error('Mauvais type de fichier importé. Type correct : jpg, png, jpeg');

            }
            $user->code_medecin = Appcontroller::str_random(8);
           if ($usersTable->save($user)) {
                $link = array(
                    'controller' => 'users',
                    'action' => 'confirm',
                    'token' => $user->id_user.'-'.md5($user->Password)
                );
                $user->confirmed_token = md5($user->Password);
                $usersTable->save($user);
                $mail = new Email();
                $mail->setFrom('support@exemple.com')
                     ->setTo($user->email)
                     ->setSubject('Confirmation d\'enregistrement ')
                     ->setEmailFormat('html')
                     ->setTemplate('confirmation')
                     ->setViewVars(array(
                        'nom' => $user->nom.' '.$user->prenom,
                        'link' => $link
                     ))
                     ->send();
                $this->Flash->set('Vous avez été enregistrer avec succès, un email de confirmation vous a été envoyé.', ['element' => 'success']);
                return $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'signup',
                ));
           }else{
                $this->Flash->set('Certains champs ont été mal saisis', ['element' => 'danger']);
           }
        }
        $this->set('new_user', $new_user);
        $this->render('signup', 'standard');
    }

    function edit($id = null){

        $usersTable = TableRegistry::get('Users');
        $user = $usersTable->get($id);
        if (!$user) {
            $this->Flash->error('Ce profil n\'exite pas');
            return $this->redirect(['action' => 'logout']);
        }
        if ($this->request->is(array('post','put'))) {
            if(empty($this->request->getData()['Password']) || $this->request->getData()['Password'] != $this->request->getData()['Password_verify']){
                $this->Flash->set('Mots de passe différents !', ['element' => 'error']);
            }else{
                $user = $usersTable->newEntity($this->request->getData());
                if ($usersTable->save($user)) {
					          $this->Flash->set('Vos informations ont été mis à jour avec succès.', ['element' => 'success']);
                    return $this->redirect(['action' => 'index']);
                }else{
                    $this->Flash->set('Certains champs ont été mal saisis', ['element' => 'error']);
                }
            }
        }
        $this->set('user_edit', $user);
        $this->render('edit', 'standard');
    }

    function confirm(){
        $token = $_GET['token'];
        $token = explode('-', $token);
        $usersTable = TableRegistry::get('Users');
        $user = $usersTable->find()
                            ->where(
                                [
                                    'id_user' => $token[0],
                                    'confirmed_token' => $token[1],
                                ]
                            )
                            ->limit(1)
                            ->all();
        if(!empty($user->first())){
            $user = $user->first();
            $user->confirmed_at = date('Y-m-d H:m:s');
            $user->confirmed_token = NULL;
            $usersTable->save($user);
            $this->Flash->set('Bienvenue '.$user->nom.' '.$user->prenom, ['element' => 'success']);
            $this->Auth->setUser($user);
            return $this->redirect($this->Auth->redirectUrl());
        }else{
            $this->Flash->set('Ce lien n\'est plus valide.', ['element' => 'error']);
            return $this->redirect(array(
                'controller' => 'users',
                'action' => 'login',
            ));
        }
    }

    function remember(){
        if($this->request->is('post')){
            $usersTable = TableRegistry::get('Users');
            $data = $this->request->getData();
            $user = $usersTable->find()
                ->where([
                    'email' => $data['email'],
                ])
                ->limit(1)
                ->all();
            if(empty($user->first())){
                $this->Flash->error('Aucun Profil ne correspond à cette email.');
                return $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'reset_password',
                ));
            }else{
                $user = $user->first();
				/*$link = array(
                    'controller' => 'users',
                    'action' => 'reset_password',
                    'token' => $user->id.'-'.md5($user->password)
                );*/
                $link = "http://localhost/GDS-1.0/users/reset_password/?token=".$user->id_user.'-'.md5($user->password);
                $user->reset_token = md5($user->password);
                $usersTable->save($user);
                $mail = new Email();
                $mail->setFrom('support@exemple.com')
                    ->setTo($user->email)
                    ->setSubject('Mot de Passe Oublié')
                    ->setEmailFormat('html')
                    ->setTemplate('forget_password')
                    ->setViewVars(array(
                        'last_name' => $user->nom.' '.$user->prenom,
                        'link' => $link
                    ))
                    ->send();
                $this->Flash->success('Un email a été envoyer à votre boîte mail pour réinitialiser votre mot de passe.');
            }
        }
    }

    function resetPassword(){
        $usersTable = TableRegistry::get('Users');

        if(!empty($_GET['token'])){
            $token = $_GET['token'];
            $token = explode('-', $token);
            $user = $usersTable->find()
                ->where([
                    'id_user' => $token[0],
                    'reset_token' =>$token[1],
                ])
                ->limit(1)
                ->all();
            if(empty($user->first())){
                $this->Flash->error('Ce lien n\'est pas valide.');
                return $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login',
                ));
            }else{
                $email = $user->first()->email;
                $this->set('email', $email);
            }
        }

        if($this->request->is('post')){
            if(empty($this->request->getData()['password']) || $this->request->getData()['password'] != $this->request->getData()['password_verify']){
                $this->Flash->set('Mots de passe différents !', ['element' => 'error']);
                return $this->render('reset_password');
            }
            $user = $usersTable->find()
                ->where([
                    'email' => $this->request->getData()['email'],
                ])
                ->limit(1)
                ->all();
            $user = $user->first();
            if (!$user) {
                $this->Flash->error('Cette utilisateur n\'est pas valide.');
                return $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login',
                ));
            }
            $user->reset_at = date('Y-m-d H:m:s');
            $user->reset_token = NULL;
            $user->password = $this->request->getData()['password'];
            $usersTable->save($user);
            $this->Auth->setUser($user);
            $this->Flash->success('Mot de passe réinitialisé avec succès.');
            return $this->redirect([
                'controller' => 'Declarations',
                'action' => 'index',
            ]);

        }
    }

    public function profil(){

    }

    public function list(){
        $usersTable = TableRegistry::get('Users');
        $users = $usersTable->find()->all();
        $this->set('users', $users);
    }

    public function delete(){
        if(empty($this->request->params['?']['user'])){
            $this->Flash->error('Information manquante.');
            return $this->redirect(['action' => 'logout']);
        }else{
            $id = (int)$this->request->params['?']['user'];
        }
        $usersTable = TableRegistry::get('Users');
        $user = $usersTable->get($id);
        if (!$user) {
            $this->Flash->error('Ce profil n\'exite pas');
            return $this->redirect(['action' => 'logout']);
        }else{
            $usersTable->delete($user);
            $this->Flash->set('Le membre a été supprimé avec succès.', ['element' => 'success']);
            $this->redirect(['controller' => 'Users','action' => 'index']);
        }
    }

    public function ebilling(){

    }
}
