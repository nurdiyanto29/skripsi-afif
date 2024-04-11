<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;

use App\Notifications\ForDeveloper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Telegram\TelegramUpdates;

class HomeController extends Controller
{
    public function index(){

      return view('admin.dashboard');
    }


}
