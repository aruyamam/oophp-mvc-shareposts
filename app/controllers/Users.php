<?php

class Users extends Controller
{
   public function __construct()
   {

   }

   public function register()
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         // Sanitize POST data
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

         $data = [
            'name' => trim($_POST['name']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'name_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => '',
         ];

         // Validation
         if (empty($data['email'])) {
            $data['email_err'] = 'Please enter email';
         }

         if (empty($data['name'])) {
            $data['name_err'] = 'Please enter name';
         }

         if (empty($data['password'])) {
            $data['password_err'] = 'Please enter Password';
         }
         elseif (strlen($data['password']) < 6) {
            $data['password_err'] = 'Password must be at least 6 characters';
         }

         if (empty($data['confirm_password'])) {
            $data['confirm_password_err'] = 'Please confirm Password';
         }
         else {
            if ($data['password'] != $data['confirm_password']) {
               $data['confirm_password_err'] = 'Passwords do not match';
            }
         }

         // Make sure errors are empty
         if (
            empty($data['email_err'])
            && empty($data['name_err'])
            && empty($data['password_err'])
            && empty($data['confirm_password_err'])
         ) {
            die('Success');
         }
         else {
            $this->view('users/register', $data);
         }
      }
      else {
         // init data
         $data = [
            'name' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => '',
            'name_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => '',
         ];

         // load view
         $this->view('users/register', $data);
      }
   }

   public function login()
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $data = [
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'email_err' => '',
            'password_err' => '',
         ];

         // Validation
         if (empty($data['email'])) {
            $data['email_err'] = 'Please enter email';
         }

         if (empty($data['password'])) {
            $data['password_err'] = 'Please enter Password';
         }

         // Make sure errors are empty
         if (
            empty($data['email_err'])
            && empty($data['password_err'])
         ) {
            die('Success');
         }
         else {
            $this->view('users/login', $data);
         }
      }
      else {
         // init data
         $data = [
            'email' => '',
            'password' => '',
            'email_err' => '',
            'password_err' => '',
         ];

         // load view
         $this->view('users/login', $data);
      }
   }
}