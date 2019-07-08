<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     @include('partials._head')     
</head>
<body>
 <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Intranet <small><i>(ver. 0.1)</i></small></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><strong>{{ Auth::user()->userUnreadSecurityMessagesNumbers() }}</strong> 
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        @foreach(Auth::user()->userUnreadSecurityNotifications() as $notification)
                        <!--@if(strpos($notification->type, 'SecurityInform'))-->
                        <li>
                            <a href="{{ Url($notification->getShowLink()) }}">
                                <div><span class="fa fa-bullhorn fa-fw"></span>
                                    <strong>{{ $notification->getCategory() }}</strong>
                                    <span class="pull-right text-muted">
                                        <em>{{ $notification->getCreatedAt() }}</em>
                                    </span>
                                </div>
                                <div><span class="text-danger"> {{ $notification->getTitle() }} </span> - <small>{{ $notification->getText() }}</small></div> 
                            </a>
                        </li> 
                        <li class="divider"></li>
                        @endif
                        @endforeach
                        <li>
                            <a class="text-center" href="{{ route('messages.index') }}">
                                <strong>@lang('messages.btn-read-all-messages')</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul> 
                </li>  
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user"><!--
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li> -->
                        <li class="divider"></li>
                        <li><a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i> Odhlásiť sa</a>
                                                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                        </li>
                    </ul> 
                </li> 
            </ul> 

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                           {{ auth()->user()->fullname() }}
                            <!-- /input-group -->
                        </li> 
                        <li>
                            <a href="#"><i class="fa fa-globe fa-fw"></i> Terminológia<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level"> 
                                <li>
                                    <a href="https://terminologia.unms.sk" target="_blank">Terminologická DB</a>
                                </li>
                                <li>
                                    <a href="{{ Route('tad.statistic') }}" target="_blank">Štatistiky</a>
                                </li> 
                            @if (auth()->user()->hasAnyRole(['term-tad','administrator'])) 
                                <li>
                                    <a href="{{ Route('tad.index') }}">Vloženie TaD</a>
                                </li> 
                            @endif 
                            @if (auth()->user()->hasAnyRole(['term-obsahy','administrator']))
                                <li>
                                    <a href="{{ Route('obsahy.index') }}">Vloženie Obsahov</a>
                                </li> 
                            @endif
                            </ul>
                        </li><!--
                        <li>
                            <a href="#"><i class="fa fa-book fa-fw"></i> Zoznam STN<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level"> 
                                <li>
                                    <a href="{{ Route('zoznam-stn.index') }}"><i class="fa fa-list fa-fw"></i> Triedy a skupiny</a>
                                </li> 
                                <li>
                                    <a href="{{ Route('zoznam.ics') }}"><i class="fa fa-list fa-fw"></i> Triedenie podľa ICS</a>
                                </li> 
                            </ul>
                        </li> -->
                        <li>
                            <a href="#"><i class="fa fa-briefcase fa-fw"></i> OTN<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ Route('navrh-zrusenia-stn.index')}}"><i class="fa fa-database fa-fw"></i> @lang('otn.h-navrhy-na-zrusenie-stn')</a>
                                </li>
                                 
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="{{ url('rezervacie') }}"><i class="fa fa-table fa-fw"></i> Rezervácia miestností</a>
                        </li>
                          <li>
                            <a href="{{ Route('security-inform.index') }}"><i class="fa fa-bullhorn fa-fw"></i> Informačná bezpečnosť<span class="fa arrow"></span></a></a>
                            <ul class="nav nav-second-level"> 
                                <li>
                                    <a href="{{ Route('security-category.index') }}">Kategórie</a>
                                </li> 
                                <li>
                                    <a href="{{ Route('security-inform.index') }}">Oznamy</a>
                                </li>
                                
                            </ul>
                        </li> 
                        <li>
                            <a href="{{ Route('user.index') }}"><i class="fa fa-list-alt fa-fw"></i> Zoznam zamestnancov</a>
                        </li>
                        @if (auth()->user()->hasAnyRole(['riadiaci pracovnik','administrator']))
                        <li>  
                           <a href="{{ Route('department.index') }}"><i class="fa fa-sitemap fa-fw"></i> {{ __('messages.h-org-str')}}</a> 
                        </li>
                        @endif
                        @if (auth()->user()->hasAnyRole(['administrator','datasety_manager']))
                        <li>  
                           <a href="#"><i class="fa fa-database fa-fw"></i> Datasety</a> 
                           <ul class="nav nav-second-level"> 
                                <li>
                                    <a href="{{ Route('objednavky.show') }}"> Objednávky</a>
                                </li> 
                                <li>
                                    <a href="{{ Route('faktury.show') }}"> Faktury</a>
                                </li>
                                
                            </ul>
                        </li>
                        @endif

                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav> 
           @yield('content') 
    </div>
    <!-- /#wrapper --> 
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/metisMenu.min.js') }}"></script>
<script src="{{ asset('js/raphael.min.js') }}"></script>
<script src="{{ asset('js/morris.min.js') }}"></script>
<script src="{{ asset('js/morris-data.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.js') }}"></script>
@yield('scripts')
</body>
</html>
