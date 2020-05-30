<style type="text/css">
</style>
<aside class="app-sidebar" style="background-color: #607fd7" >
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">
    
    <div>
      <div class=""><span style="margin-right: 10px; font-family: bold; font-size: 15px">{{ ucwords(auth()->user()->name) }}</span></div>
    </div>
  </div>
  <ul class="app-menu">
    @role('hrms_admin|hrms_hr')
    <li>
      <a class="app-menu__item {{request()->path() == '/' ? 'active' : ''}} " href="{{url('/')}}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a>
    </li>
    @endrole
    <li>
      <a class="app-menu__item {{request()->segment(1) == 'information' ? 'active' : ''}} " href="{{route('information.index')}}">
        <i class="app-menu__icon fa fa-address-book-o"></i><span class="app-menu__label">Profile</span>
      </a>
    </li>

    @role('hrms_admin|hrms_hr')
      <li >
      <a class="app-menu__item {{request()->segment(2) == 'employees' ? 'active' : ''}} " href="{{route('employees.index')}}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Employees</span>
      </a>
    </li>
    @endrole
    {{-- For Admin --}}

    @role('hrms_admin')
    <li>
      <a class="app-menu__item {{Request::segment(2) == 'admin' ? 'active' : ''}} " href="{{route('request.admin')}}"><i class="app-menu__icon fa fa-pencil-square-o"></i><span class="app-menu__label">Leaves Request (Admin)</span>
      </a>
    </li>
     
    @endrole

    {{-- For HR --}}
    @role('hrms_hr')
    
    <li>
      <a class="app-menu__item {{Request::segment(1) == 'leave-request' ? 'active' : ''}} " href="{{route('request.hr')}}"><i class="app-menu__icon fa fa-pencil-square-o"></i><span class="app-menu__label">Leaves Request (HR)</span>
      </a>
    </li>
     
    @endrole

    {{-- For Teamead --}}
    @role('hrms_teamlead')
  
    <li>
      <a class="app-menu__item {{Request::segment(2) == 'teamlead' ? 'active' : ''}} " href="{{route('request.teamlead')}}"><i class="app-menu__icon fa fa-pencil-square-o"></i><span class="app-menu__label">Leaves Request (TL)</span>
      </a>
    </li>
    
    @endrole

    {{-- For Employees --}}
    @role('hrms_employee|hrms_teamlead|hrms_hr')
    
    @if(session('leave')['allotment'] && !empty(session('leave')['reallotment'][0]->status)?session('leave')['reallotment'][0]->status:'' == 1)
     <li><a class="app-menu__item"   href="{{url('employee/leaves')}}"><i class="app-menu__icon fa fa-angle-double-right"></i><span class="app-menu__label">Apply Leave</span></a></li>
    @endif
    @endrole


    {{---  Recruitment   --}}
      
      @role('hrms_admin')
        <li>
          <a class="app-menu__item {{Request::segment(1) == 'recruit-posting' ? 'active' : ''}} " href="{{route('recruit.admin')}}"><i class="app-menu__icon fa fa-pencil-square-o"></i><span class="app-menu__label">Recruitment Posting (Admin)</span>
          </a>
        </li>
      @endrole

      @role('hrms_subadmin')

      <li>
        <a class="app-menu__item {{Request::segment(1) == 'recruit-posting' ? 'active' : ''}} " href="{{route('recruit.subadmin')}}"><i class="app-menu__icon fa fa-pencil-square-o"></i><span class="app-menu__label">Recruitment Posting (SubAdmin)</span>
        </a>
      </li>

      @endrole

      @ability('hrms_recruiter', 'generate-recruitment-request')
      <li>
        <a class="app-menu__item {{Request::segment(1) == 'recruitment' ? 'active' : ''}} " href="{{route('recruitment.index')}}"><i class="app-menu__icon fa fa-pencil-square-o"></i><span class="app-menu__label">Recruitment Requests</span>
        </a>
      </li>
      @endability

      @permission('manage-recruitment-request')
      <li>
        <a class="app-menu__item {{Request::segment(1) == 'recruit-posting' ? 'active' : ''}} " href="{{route('recruit.hr')}}"><i class="app-menu__icon fa fa-pencil-square-o"></i><span class="app-menu__label">Recruitment Posting (HR)</span>
        </a>
      </li>
      @endpermission

    {{-- Employees tab --}}

{{--     @role('hrms_admin|hrms_hr') --}}

    {{-- Leave Management Tab --}}

      @ability('hrms_admin', 'leave-management')

        <li class="treeview {{call_user_func_array('Request::is', (array)['leave*']) ? 'is-expanded' : ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-group "></i><span class="app-menu__label">Leave Management</span><i class="treeview-indicator fa fa-angle-right"></i></a>
        <ul class="treeview-menu">
          <li class={{call_user_func_array('Request::is', (array)['leave-management/type*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('types.index')}}"><i class="icon fa fa-angle-double-right"></i>Leave Type</a></li>
          <li class={{call_user_func_array('Request::is', (array)['leave-management/allotment*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('allotments.index')}}"><i class="icon fa fa-angle-double-right"></i>Leave Allotment</a></li>
          <li class={{call_user_func_array('Request::is', (array)['leave-management/holidays*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('holidays.index')}}"><i class="icon fa fa-angle-double-right"></i>Holidays</a></li>
        </ul>
      </li>

      @endability

      {{-- Loan Tab --}}  
    <li><a class="app-menu__item {{Request::segment(1) == 'loan-request' ? 'active' : ''}}" href="{{route('loan-request.index')}}"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Loan</span></a></li>
    
    {{--  --}}

     

    {{-- Separation Tab --}}


      @permission('hrms-manage-staff-separation')
        <li><a class="app-menu__item {{Request::segment(1) == 'separation' ? 'active' : ''}}" href="{{route('separation-hr.index')}}"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Separation (HR)</span></a></li>
      @endpermission

    @role('hrms_subadmin')
      <li><a class="app-menu__item {{Request::segment(1) == 'separation' ? 'active' : ''}}" href="{{route('separation-subadmin.index')}}"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Separation (SubAdmin)</span></a></li>
    @endrole

      @role('hrms_admin')
        <li><a class="app-menu__item {{Request::segment(1) == 'separation' ? 'active' : ''}}" href="{{route('separation-admin.index')}}"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Separation (Admin)</span></a></li>
      @endrole

    {{--  --}}

    {{-- Loan Listing --}}
     @permission('hrms-manage-loan-request')
        {{-- <li class={{call_user_func_array('Request::is', (array)['loan-management/listing*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('loan-listing-hr.index')}}"><i class="icon fa fa-angle-double-right"></i>Loan Listings (HR)</a></li>
 --}}
        <li><a class="app-menu__item {{Request::segment(1) == 'loan-listing' ? 'active' : ''}}" href="{{route('loan-listing-hr.index')}}"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Loan Listings (HR)</span></a></li>

        {{-- {{dd(Request::segment(1))}} --}}
      @endpermission

      @role('hrms_subadmin')
       {{--  <li class={{call_user_func_array('Request::is', (array)['loan-management/listing*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('loan-listing-subadmin.index')}}"><i class="icon fa fa-angle-double-right"></i>Loan Listings (SubAdmin)</a></li> --}}

         <li><a class="app-menu__item {{Request::segment(1) == 'loan-listing' ? 'active' : ''}}" href="{{route('loan-listing-subadmin.index')}}"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Loan Listings (SubAdmin)</span></a></li>
      @endrole

      @role('hrms_admin')
        {{-- <li class={{call_user_func_array('Request::is', (array)['loan-management/listing*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('loan-listing-admin.index')}}"><i class="icon fa fa-angle-double-right"></i>Loan Listings (Admin)</a></li> --}}

        <li><a class="app-menu__item {{Request::segment(1) == 'loan-listing' ? 'active' : ''}}" href="{{route('loan-listing-admin.index')}}"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Loan Listings (Admin)</span></a></li>
      @endrole

      @permission('hrms-accountant')
       
        <li><a class="app-menu__item {{Request::segment(1) == 'loan-listing' ? 'active' : ''}}" href="{{route('loan-listing-accountant.index')}}"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Loan Listings (Acc.)</span></a></li>
      @endpermission

    

     {{-- Settings Tab --}}

      @ability('hrms_admin', 'manage-settings')
         <li><a class="app-menu__item {{Request::segment(1) == 'settings' ? 'active' : ''}}" href="{{route('mast_entity.home')}}"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Settings</span></a></li>
      @endability
      
      <li><a class="app-menu__item {{Request::segment(1) == 'branches' ? 'active' : ''}}" href="{{route('branches.index')}}"><i class="app-menu__icon fa fa-plus-square-o"></i><span class="app-menu__label">Add Branch</span></a></li>


      @ability('hrms_admin', 'manage-birthday')
        <li class="treeview {{call_user_func_array('Request::is', (array)['birthday*']) ? 'is-expanded' : ''}}" ><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-book "></i><span class="app-menu__label">Birthday</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
          <li class={{call_user_func_array('Request::is', (array)['birthday_wish*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('birthday_wish.index')}}"><i class="icon fa fa-angle-double-right"></i>Birthday Wish</a></li>
          <li class={{call_user_func_array('Request::is', (array)['get_message*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('get_message')}}"><i class="icon fa fa-angle-double-right"></i>Add  B'day Message</a></li>
         

          </ul>
        </li>
      @endability

    {{-- User's role & permissions --}} 
    
    @if(Auth::id() == 65)
    <li class="treeview {{call_user_func_array('Request::is', (array)['acl*']) ? 'is-expanded' : ''}}" ><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-book "></i><span class="app-menu__label">User Management</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li class={{call_user_func_array('Request::is', (array)['acl/roles*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('roles.index')}}"><i class="icon fa fa-angle-double-right"></i>Roles</a></li>
        <li class={{call_user_func_array('Request::is', (array)['acl/permissions*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('permissions.index')}}"><i class="icon fa fa-angle-double-right"></i>Permissions</a></li>
        <li class={{call_user_func_array('Request::is', (array)['acl/users*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('users.index')}}"><i class="icon fa fa-angle-double-right"></i>Users</a></li>
      {{-- @endrole --}}

      </ul>
    </li>
    @endif
{{-- @endability --}}
     {{-- <li><a class="app-menu__item {{Request::segment(1) == 'attendance' ? 'active' : ''}}" href="{{route('attendance.index')}}"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Attendance</span></a></li> --}}

</aside>
<script>
  $("#nav").click(function(e){
    e.preventDefault(); 
    $("#togal").toggle(500);
    $("#togal").show()
  });
  
</script>


