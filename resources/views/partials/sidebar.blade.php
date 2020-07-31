<style type="text/css">
</style>
<aside class="app-sidebar" style="background-color: #607fd7" >
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">
    <div>
      <span style="margin-right: 10px; font-family: bold; font-size: 15px">{{ ucwords(auth()->user()->name) }}
      </span>
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
        <a class="app-menu__item {{Request::segment(2) == 'admin' ? 'active' : ''}} " href="{{route('request.admin')}}"><i class="app-menu__icon fa fa-envelope-open-o"></i><span class="app-menu__label">Leaves Request (Admin)</span>
        </a>
      </li>
    @endrole

    {{-- For HR --}}
    @role('hrms_hr')
    
      <li>
        <a class="app-menu__item {{Request::segment(1) == 'leave-request' ? 'active' : ''}} " href="{{route('request.hr')}}"><i class="app-menu__icon fa fa-envelope-open-o"></i><span class="app-menu__label">Leaves Request (HR)</span>
        </a>
      </li>
     
    @endrole

    {{-- For Teamead --}}
    @role('hrms_teamlead')
  
      <li>
        <a class="app-menu__item {{Request::segment(2) == 'teamlead' ? 'active' : ''}} " href="{{route('request.teamlead')}}"><i class="app-menu__icon fa fa-envelope-open-o"></i><span class="app-menu__label">Leaves Request (TL)</span>
        </a>
      </li>
    
    @endrole

    {{-- For Employees --}}
    @role('hrms_employee|hrms_teamlead|hrms_hr')

      @if(session('leave')['allotment'] && !empty(session('leave')['reallotment'][0]->status)?session('leave')['reallotment'][0]->status:'' == 1)
        <li><a class="app-menu__item"   href="{{url('employee/leaves')}}"><i class="app-menu__icon fa fa-pencil"></i><span class="app-menu__label">Apply Leave</span></a></li>
      @endif
    @endrole

    {{---  Recruitment   --}}
      
    @role('hrms_admin')
      <li>
        <a class="app-menu__item {{Request::segment(1) == 'recruit-posting' ? 'active' : ''}} " href="{{route('recruit.admin')}}"><i class="app-menu__icon fa fa-address-book"></i><span class="app-menu__label">Recruitment Posting (Admin)</span>
        </a>
      </li>
    @endrole

    @role('hrms_subadmin')

      <li>
        <a class="app-menu__item {{Request::segment(1) == 'recruit-posting' ? 'active' : ''}}" href="{{route('recruit.subadmin')}}"><i class="app-menu__icon fa fa-address-book"></i>
        <span class="app-menu__label">Recruitment Posting (SubAdmin)</span>
        </a>
      </li>

    @endrole

    @ability('hrms_recruiter', 'generate-recruitment-request')

      <li>
        <a class="app-menu__item {{Request::segment(1) == 'recruitment' ? 'active' : ''}} " href="{{route('recruitment.index')}}"><i class="app-menu__icon fa fa-address-book"></i><span class="app-menu__label">Recruitment Requests</span>
        </a>
      </li>

    @endability

    @permission('manage-recruitment-request')
      <li>
        <a class="app-menu__item {{Request::segment(1) == 'recruit-posting' ? 'active' : ''}} " href="{{route('recruit.hr')}}"><i class="app-menu__icon fa fa-address-book"></i><span class="app-menu__label">Recruitment Posting (HR)</span>
        </a>
      </li>
    @endpermission

  {{-- Leave Management Tab --}}

    @ability('hrms_admin', 'leave-management')

      <li class="treeview {{call_user_func_array('Request::is', (array)['leave*']) ? 'is-expanded' : ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-table "></i><span class="app-menu__label">Leave Management</span><i class="treeview-indicator fa fa-angle-right"></i></a>
        <ul class="treeview-menu">
          <li class={{call_user_func_array('Request::is', (array)['leave-management/type*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('types.index')}}"><i class="icon fa fa-chevron-right"></i>Leave Type</a></li>
          <li class={{call_user_func_array('Request::is', (array)['leave-management/allotment*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('allotments.index')}}"><i class="icon fa fa-chevron-right"></i>Leave Allotment</a></li>
          <li class={{call_user_func_array('Request::is', (array)['leave-management/holidays*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('holidays.index')}}"><i class="icon fa fa-chevron-right"></i>Holidays</a></li>
        </ul>
      </li>

    @endability

    {{-- Loan Tab --}}

    <li><a class="app-menu__item {{Request::segment(1) == 'loan-request' ? 'active' : ''}}" href="{{route('loan-request.index')}}"><i class="app-menu__icon fa fa-money"></i><span class="app-menu__label">Apply for Loan </span></a></li>

    {{-- No Dues Request --}}

    {{-- <li><a class="app-menu__item {{Request::segment(1) == 'no-dues-request.index' ? 'active' : ''}}" href="{{route('no-dues-request.index')}}"><i class="app-menu__icon fa fa-money"></i><span class="app-menu__label">No Dues Request </span></a></li> --}}
    

    {{-- For Employees --}}
    @role('hrms_employee')
   <li class="treeview {{call_user_func_array('Request::is', (array)['issue*']) ? 'is-expanded' : ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-table "></i><span class="app-menu__label">Indent & No Dues</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
          <li class={{call_user_func_array('Request::is', (array)['my-indent*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('my-indent.index')}}"><i class="icon fa fa-chevron-right"></i>My Indent</a></li>
          <li class={{call_user_func_array('Request::is', (array)['no-dues-request*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('no-dues-request.index')}}"><i class="icon fa fa-chevron-right"></i>No Dues Request</a></li>
      </ul>
    </li>
    @endrole
    
      {{-- For HR --}}

      {{-- @role('hrms_hr') --}}
    @permission('hrms-manage-issue-indent')
      <li class="treeview {{call_user_func_array('Request::is', (array)['issue*']) ? 'is-expanded' : ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-table "></i><span class="app-menu__label">Indent & No Dues</span><i class="treeview-indicator fa fa-angle-right"></i></a>
        <ul class="treeview-menu">
          <li class={{call_user_func_array('Request::is', (array)['issue-indent*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('issue-indent.index')}}"><i class="icon fa fa-chevron-right"></i>Issue Indent</a></li>
          <li class={{call_user_func_array('Request::is', (array)['no-dues-listing*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('hr.nodues')}}"><i class="icon fa fa-chevron-right"></i>No Dues Listing</a></li>
          <li class={{call_user_func_array('Request::is', (array)['item-request*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('item-request.index')}}"><i class="icon fa fa-chevron-right"></i>Issue Indent Requests</a></li>
        </ul>
      </li>
    @endpermission
    {{-- @endrole --}}

    @permission('hrms-manage-staff-separation')
      <li><a class="app-menu__item {{Request::segment(1) == 'separation' ? 'active' : ''}}" href="{{route('separation-hr.index')}}"><i class="app-menu__icon fa fa-chevron-right"></i><span class="app-menu__label">Separation (HR)</span></a></li>
    @endpermission

    @role('hrms_subadmin')
      <li><a class="app-menu__item {{Request::segment(1) == 'separation' ? 'active' : ''}}" href="{{route('separation-subadmin.index')}}"><i class="app-menu__icon fa fa-chevron-right"></i><span class="app-menu__label">Separation (SubAdmin)</span></a></li>
    @endrole

    @role('hrms_admin')
      <li><a class="app-menu__item {{Request::segment(1) == 'separation' ? 'active' : ''}}" href="{{route('separation-admin.index')}}"><i class="app-menu__icon fa fa-chevron-right"></i><span class="app-menu__label">Separation (Admin)</span></a></li>
    @endrole

     {{--@if(hod_check(Auth::user()->id) != null)
      <li class="treeview {{call_user_func_array('Request::is', (array)['miscellaneous*']) ? 'is-expanded' : ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-table "></i><span class="app-menu__label">Miscellaneous</span><i class="treeview-indicator fa fa-angle-right"></i></a>
        <ul class="treeview-menu">
          
          <li class={{call_user_func_array('Request::is', (array)['miscellaneous/type*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('no-dues-listing.index')}}"><i class="icon fa fa-chevron-right"></i>No dues Listing</a></li>
          
          <li class={{call_user_func_array('Request::is', (array)['miscellaneous/allotment*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('allotments.index')}}"><i class="icon fa fa-chevron-right"></i>Leave Allotment</a></li>
          <li class={{call_user_func_array('Request::is', (array)['miscellaneous/holidays*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('holidays.index')}}"><i class="icon fa fa-chevron-right"></i>Holidays</a></li> 
        </ul>
      </li>
      @endif--}}
  {{-- Loan Listing --}}

    {{-- @permission('hrms-manage-loan-request')
      
      <li><a class="app-menu__item {{Request::segment(1) == 'loan-listing' ? 'active' : ''}}" href="{{route('loan-listing-hr.index')}}"><i class="app-menu__icon fa fa-chevron-right"></i><span class="app-menu__label">Loan Listings (HR)</span></a></li>

    @endpermission

    @role('hrms_subadmin')
       <li><a class="app-menu__item {{Request::segment(1) == 'loan-listing' ? 'active' : ''}}" href="{{route('loan-listing-subadmin.index')}}"><i class="app-menu__icon fa fa-chevron-right"></i><span class="app-menu__label">Loan Listings (SubAdmin)</span></a></li>
    @endrole

    @role('hrms_admin')
      <li><a class="app-menu__item {{Request::segment(1) == 'loan-listing' ? 'active' : ''}}" href="{{route('loan-listing-admin.index')}}"><i class="app-menu__icon fa fa-chevron-right"></i><span class="app-menu__label">Loan Listings (Admin)</span></a></li>
    @endrole

    @permission('hrms-accountant')
     
      <li><a class="app-menu__item {{Request::segment(1) == 'loan-listing' ? 'active' : ''}}" href="{{route('loan-listing-accountant.index')}}"><i class="app-menu__icon fa fa-chevron-right"></i><span class="app-menu__label">Loan Listings (Acc.)</span></a></li>
    @endpermission --}}
    @role('hrms_admin|hrms_subadmin|hrms_hr')
      <li class="treeview {{call_user_func_array('Request::is', (array)['loan-management*']) ? 'is-expanded' : ''}}" ><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-table "></i><span class="app-menu__label">Loan Management</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">

        @role('hrms_hr')
        <li class={{call_user_func_array('Request::is', (array)['loan-management/loan-listing/hr*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('loan-listing-hr.index')}}"><i class="icon fa fa-chevron-right"></i>Loan Listing (Hr)</a></li>
        @endrole
        @role('hrms_subadmin')
        <li class={{call_user_func_array('Request::is', (array)['loan-management/loan-listing/subadmin*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('loan-listing-subadmin.index')}}"><i class="icon fa fa-chevron-right"></i>Loan Listing (SubAdmin)</a></li>
        @endrole
        @role('hrms_admin')
        <li class={{call_user_func_array('Request::is', (array)['loan-management/loan-listing/admin*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('loan-listing-admin.index')}}"><i class="icon fa fa-chevron-right"></i>Loan Listing (Admin)</a></li>

        @endrole
        @role('hrms_accountant')
        <li class={{call_user_func_array('Request::is', (array)['loan-management/loan-listing/accountant*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('loan-listing-accountant.index')}}"><i class="icon fa fa-chevron-right"></i>Loan Listing (Acc.)</a></li>
        @endrole

        <li class={{call_user_func_array('Request::is', (array)['loan-management/loan-types*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('loan-types.index')}}"><i class="icon fa fa-chevron-right"></i>Types</a></li>
      </ul>
      </li>
      @endrole

    <!--Payroll -->
    @role('hrms_admin|hrms_hr')
    <li class="treeview {{call_user_func_array('Request::is', (array)['hrpayroll*']) ? 'is-expanded' : ''}}" ><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-book "></i><span class="app-menu__label">Payroll</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li class={{call_user_func_array('Request::is', (array)['hrpayroll/chapter6-exemption*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('chapter6-exemption.index')}}"><i class="icon fa fa-chevron-right"></i>Chapter 6 Exemptions</a></li>
        <li class={{call_user_func_array('Request::is', (array)['hrpayroll/welfare*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('welfare.index')}}"><i class="icon fa fa-chevron-right"></i>Welfare</a></li>
        <li class={{call_user_func_array('Request::is', (array)['hrpayroll/allowance*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('allowance.index')}}"><i class="icon fa fa-chevron-right"></i>Allowance</a></li>
        <li class={{call_user_func_array('Request::is', (array)['hrpayroll/chapt6-head*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('chapt6-head.index')}}"><i class="icon fa fa-chevron-right"></i>Chapter 6 Head</a></li>
        
      </ul>
    </li>
    @endrole
    @role('hrms_admin|hrms_hr')
      <li><a class="app-menu__item {{Request::segment(1) == 'branches' ? 'active' : ''}}" href="{{route('branches.index')}}"><i class="app-menu__icon fa fa-map-marker"></i><span class="app-menu__label">Add Branch</span></a></li>
    @endrole

  {{-- payroll Tab --}}
{{-- 
    <li class="treeview {{call_user_func_array('Request::is', (array)['payroll-settings*']) ? 'is-expanded' : ''}}" ><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-book "></i><span class="app-menu__label">Payroll Setting</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li class={{call_user_func_array('Request::is', (array)['payroll-settings/chapter6-head*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{-- {{route('chapter6-head.index')}} "><i class="icon fa fa-chevron-right"></i>Chapter 6 Section Head</a></li>
        <li class={{call_user_func_array('Request::is', (array)['payroll-settings/financial-year*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('financial-year.index')}}"><i class="icon fa fa-chevron-right"></i>Financial Year</a></li>
      </ul>
    </li> --}}


    @ability('hrms_admin|hrms_hr', 'manage-settings')
       <li><a class="app-menu__item {{Request::segment(1) == 'settings' ? 'active' : ''}}" href="{{route('mast_entity.home')}}"><i class="app-menu__icon fa fa-bars"></i><span class="app-menu__label">Settings</span></a></li>
    @endability

    @ability('hrms_admin|hrms_hr', 'manage-settings')
       <li><a class="app-menu__item {{Request::segment(1) == 'hod' ? 'active' : ''}}" href="{{route('hod.index')}}"><i class="app-menu__icon fa fa-bars"></i><span class="app-menu__label">HOD</span></a></li>
    @endability
    
    @ability('hrms_admin|hrms_hr', 'manage-birthday')
      <li class="treeview {{call_user_func_array('Request::is', (array)['birthday*']) ? 'is-expanded' : ''}}" ><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-birthday-cake "></i><span class="app-menu__label">Birthday</span><i class="treeview-indicator fa fa-angle-right"></i></a>
        <ul class="treeview-menu">
        <li class={{call_user_func_array('Request::is', (array)['birthday_wish*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('birthday_wish.index')}}"><i class="icon fa fa-chevron-right"></i>Birthday Wish</a></li>
        <li class={{call_user_func_array('Request::is', (array)['get_message*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('get_message')}}"><i class="icon fa fa-chevron-right"></i>Add  B'day Message</a></li>
       

        </ul>
      </li>
    @endability

    {{-- User's role & permissions --}} 
    
    @if(Auth::id() == 65 || Auth::id() == 20)
      <li class="treeview {{call_user_func_array('Request::is', (array)['acl*']) ? 'is-expanded' : ''}}" ><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-book "></i><span class="app-menu__label">User Management</span><i class="treeview-indicator fa fa-angle-right"></i></a>
        <ul class="treeview-menu">
          <li class={{call_user_func_array('Request::is', (array)['acl/roles*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('roles.index')}}"><i class="icon fa fa-chevron-right"></i>Roles</a></li>
          <li class={{call_user_func_array('Request::is', (array)['acl/permissions*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('permissions.index')}}"><i class="icon fa fa-chevron-right"></i>Permissions</a></li>
          <li class={{call_user_func_array('Request::is', (array)['acl/users*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('users.index')}}"><i class="icon fa fa-chevron-right"></i>Users</a></li>
        </ul>
      </li>
     @endif 

</aside>
<script>
  $("#nav").click(function(e){
    e.preventDefault(); 
    $("#togal").toggle(500);
    $("#togal").show()
  });
  
</script>


