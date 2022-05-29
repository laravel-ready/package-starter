<?php

namespace LaravelReady\PackageStarter\Http\Controllers\Web;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Routing\Controller;

class WebBaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
