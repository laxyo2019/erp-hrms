
<aside class="app-sidebar" >
  
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">
    <div>
      <div class=""><span style="margin-right: 10px; font-family: bold; font-size: 15px">{{ ucwords(auth()->user()->name) }}</span></div>
      {{-- <p class="app-sidebar__user-designation">Admin Access</p> --}}
    </div>
  </div>
  <ul class="app-menu">
    <li>
      <a class="app-menu__item {{request()->path() == '/' ? 'active' : ''}} " href="{{url('/')}}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a>
    </li>

    <li >
      <a class="app-menu__item {{request()->segment(1) == 'information' ? 'active' : ''}} " href="{{route('information.index')}}">
        <i class="app-menu__icon fa fa-info"></i><span class="app-menu__label">Profile</span>
      </a>
    </li>

    @role('hrms_hr|hrms_teamlead|hrms_employee')

    @if(session('leave')['allotment'] && session('leave')['reallotment'][0]->status == 1)
     <li><a class="app-menu__item" href="{{url('employee/leaves')}}"><i class="app-menu__icon fa fa-angle-double-right"></i><span class="app-menu__label">Apply Leave</span></a></li>
    @endif

    @endrole

    {{-- Employee List --}}

    @role('hrms_admin|hrms_hr')

    <li >
      <a class="app-menu__item {{request()->segment(2) == 'hrd/employees' ? 'active' : ''}} " href="{{route('employees.index')}}"><i class="app-menu__icon fa fa-info"></i><span class="app-menu__label">Employees</span>
      </a>
    </li>
    @endrole
    {{-- Leave Requests --}}

    @role('hrms_admin|hrms_hr|hrms_teamlead')

    <li >
      <a class="app-menu__item {{request()->segment(2) == 'hrd/leaves' ? 'active' : ''}} " href="{{route('leaves.index')}}"><i class="app-menu__icon fa fa-info"></i><span class="app-menu__label">Leaves Request</span>
      </a>
    </li>
    @endrole
    {{-- <li >
      <a class="app-menu__item {{request()->segment(3) == 'hrd/leaves' ? 'active' : ''}} " href="{{route('leaves.index')}}"><i class="app-menu__icon fa fa-info"></i><span class="app-menu__label">Leaves Request</span>
      </a>
    </li> --}}
      {{-- <li class={{call_user_func_array('Request::is', (array)['hrd/leaves*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('leaves.index')}}"><i class="icon fa fa-angle-double-right"></i>Leaves Request</a></li> --}}

    {{-- <a class="app-menu__item" href="{{route('information.index')}}"><i class="app-menu__icon fa fa-info"></i><span class="app-menu__label">Basic Information</span></a> --}}


{{-- <li class="treeview 
    {{call_user_func_array('Request::is', (array)['incomes*']) ? 'is-expanded' : ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-money"></i><span class="app-menu__label">Incomes</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">

        <li><a class="treeview-item" href="#"><i class="icon fa fa-angle-double-right"></i>Invoices</a></li>

        <li><a class="treeview-item" href="#" target="_blank" rel="noopener"><i class="icon fa fa-angle-double-right"></i> Revenues</a></li>

        <li><a class="treeview-item" href="#"><i class="icon fa fa-angle-double-right"></i> Customers</a></li>
      </ul>
    </li>
    
    <li class="treeview {{call_user_func_array('Request::is', (array)['expenses*']) ? 'is-expanded' : ''}}" ><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-shopping-cart "></i><span class="app-menu__label">Expenses</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{route('bills.index')}}"><i class="icon fa fa-angle-double-right"></i> Bills</a></li>
        <li><a class="treeview-item" href="{{route('payments.index')}}"><i class="icon fa fa-angle-double-right"></i> Payments</a></li>
        <li><a class="treeview-item" href="{{route('vendors.index')}}"><i class="icon fa fa-angle-double-right"></i> Vendors</a></li>
          <li class="{{call_user_func_array('Request::is', (array)['expenses/tours*']) ? 'active_subtab' : ''}}"><a class="treeview-item" href="{{route('tours.index')}}"><i class="icon fa fa-angle-double-right"></i> Tours</a></li>
      </ul>
    </li> 
--}}

    {{-- Hr Module to handle employees --}}
    @role('hrms_admin|hrms_hr')
      {{-- <li class="treeview {{call_user_func_array('Request::is', (array)['hrd*','leave*','types*','allotments*','holidays*']) ? 'is-expanded' : ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-group "></i><span class="app-menu__label">HRD</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu"> --}}
        
       
        
          {{-- <li class={{call_user_func_array('Request::is', (array)['hrd/approvals*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('approvals.index')}}"><i class="icon fa fa-angle-double-right"></i>Approvals</a></li> --}}
          
         
        
 
{{--
        <li  id="nav" class="treeview{{call_user_func_array('Request::is', (array)['hrd*','leave*','types*','allotments*','holidays*']) ? 'is-expanded' : 'active_subtab'}}"><a class="treeview-item" href="#"><i class="icon fa fa-angle-double-right"></i>Leaves Management</a>
        </li>
        <ul id="togal" style="display: none;">
          <li class={{call_user_func_array('Request::is', (array)['leave-management/type*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('types.index')}}"></i> Leave Type</a>
            </li>
          <li class={{call_user_func_array('Request::is', (array)['leave-management/allotment*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('allotments.index')}}"></i> Leave Allotment</a>
            </li>
          <li class={{call_user_func_array('Request::is', (array)['leave-management/holidays*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('holidays.index')}}"></i>Holidays</a>
            </li>
        </ul> 
--}}
      
          {{-- <li class={{call_user_func_array('Request::is', (array)['hrd/leaves*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('rules.index')}}"><i class="icon fa fa-angle-double-right"></i>Leaves Rules</a></li> 
      </ul>--}}
    @endrole
    {{-- Employees tab --}}

    
    {{-- <li class="treeview {{call_user_func_array('Request::is', (array)['employee*']) ? 'is-expanded' : ''}}">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-group "></i><span class="app-menu__label">Leaves</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
      <li class={{call_user_func_array('Request::is', (array)['employee/leaves*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{url('employee/leaves')}}"><i class="icon fa fa-angle-double-right"></i>Apply</a></li>
      </ul>
    </li> --}}

   
    
    {{-- end of module --}}

{{-- 
      <li class="treeview  
        {{call_user_func_array('Request::is', (array)['tender*']) ? 'is-expanded' : ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-group "></i><span class="app-menu__label">Tenders</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li class={{call_user_func_array('Request::is', (array)['tender_type*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('tender_type.index')}}"><i class="icon fa fa-angle-double-right"></i>Tender Types</a></li>
        <li class={{call_user_func_array('Request::is', (array)['tender_category*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('tender_category.index')}}"><i class="icon fa fa-angle-double-right"></i>Tender Categories</a></li>
        <li class={{call_user_func_array('Request::is', (array)['tender_master*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('tender_master.index')}}"><i class="icon fa fa-angle-double-right"></i>Tender Mast</a></li>
      </ul>
    </li> 
--}}

  @role('hrms_admin|hrms_hr')
    {{-- Leave Management Tab --}}

      <li class="treeview {{call_user_func_array('Request::is', (array)['leave*']) ? 'is-expanded' : ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-group "></i><span class="app-menu__label">Leave Management</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li class={{call_user_func_array('Request::is', (array)['leave-management/type*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('types.index')}}"><i class="icon fa fa-angle-double-right"></i>Leave Type</a></li>
        <li class={{call_user_func_array('Request::is', (array)['leave-management/allotment*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('allotments.index')}}"><i class="icon fa fa-angle-double-right"></i>Leave Allotment</a></li>
        <li class={{call_user_func_array('Request::is', (array)['leave-management/holidays*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('holidays.index')}}"><i class="icon fa fa-angle-double-right"></i>Holidays</a></li>
      </ul>
    </li> 

     {{-- Settings Tab --}}


      <li><a class="app-menu__item" href="{{route('mast_entity.home')}}"><i class="app-menu__icon fa fa-angle-double-right"></i><span class="app-menu__label">Settings</span></a></li>
  
{{--       
      <li class="treeview {{call_user_func_array('Request::is', (array)['settings*']) ? 'is-expanded' : ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-cog "></i><span class="app-menu__label">Settings</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li class={{call_user_func_array('Request::is', (array)['settings/mast_entity*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('mast_entity.home')}}"><i class="icon fa fa-angle-double-right"></i> Master Entities</a></li>
 
        <li><a class="treeview-item" href=""><i class="icon fa fa-angle-double-right"></i> General</a></li>
        <li><a class="treeview-item" href="{{route('categories.index')}}"><i class="icon fa fa-angle-double-right"></i> Categories</a></li>
        <li><a class="treeview-item" href="{{route('expense_in_user.create')}}"><i class="icon fa fa-angle-double-right"></i> Expense In User</a></li>          
        <li><a class="treeview-item" href="{{route('expense_permit_user.create')}}"><i class="icon fa fa-angle-double-right"></i> Expense Permit User</a></li>          
        <li><a class="treeview-item" href=""><i class="icon fa fa-angle-double-right"></i> Payment Method</a></li> 
--}}
        {{-- <li class={{call_user_func_array('Request::is', (array)['settings/designations*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('designations.index')}}"><i class="icon fa fa-angle-double-right"></i> Designation </a></li>
        <li class={{call_user_func_array('Request::is', (array)['settings/statuses*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('statuses.index')}}"><i class="icon fa fa-angle-double-right"></i> Statuses </a></li>
        <li class={{call_user_func_array('Request::is', (array)['settings/grades*']) ? 'active_subtab' : ''}}>
          <a class="treeview-item" href="{{route('grades.index')}}">
            <i class="icon fa fa-angle-double-right"></i> Grades </a>
        </li> --}}
      {{-- </ul>
    </li> --}}


    {{-- User's role & permissions --}}
    

    <li class="treeview {{call_user_func_array('Request::is', (array)['acl*']) ? 'is-expanded' : ''}}" ><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-shopping-cart "></i><span class="app-menu__label">ACL</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
       {{-- <li class={{call_user_func_array('Request::is', (array)['acl/permissions*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('permissions.index')}}"><i class="icon fa fa-angle-double-right"></i>Permissions</a></li> --}}
        <li class={{call_user_func_array('Request::is', (array)['acl/roles*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('roles.index')}}"><i class="icon fa fa-angle-double-right"></i>Roles</a></li>
         <li class={{call_user_func_array('Request::is', (array)['acl/users*']) ? 'active_subtab' : ''}}><a class="treeview-item" href="{{route('users.index')}}"><i class="icon fa fa-angle-double-right"></i>Users</a></li>

       {{--  <li><a class="treeview-item" href="{{route('vendors.index')}}"><i class="icon fa fa-angle-double-right"></i> Vendors</a></li>
          <li class="{{call_user_func_array('Request::is', (array)['expenses/tours*']) ? 'active_subtab' : ''}}"><a class="treeview-item" href="{{route('tours.index')}}"><i class="icon fa fa-angle-double-right"></i> Tours</a></li> --}}
      {{-- </ul> --}}
    {{-- </li> --}} 

    @endrole
  </ul>
</aside>
<script>
  $("#nav").click(function(e){
    e.preventDefault(); 
    $("#togal").toggle(500);
    $("#togal").show()
  });
  
</script>