<?php

namespace LaravelReady\PackageStarter\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Routing\Controller;

class AdminBaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
