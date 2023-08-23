 <!-- ========== Left Sidebar Start ========== -->
 <div class="vertical-menu">

     <div data-simplebar class="h-100">

         <!--- Sidemenu -->
         <div id="sidebar-menu">
             <!-- Left Menu Start -->
             <ul class="metismenu list-unstyled" id="side-menu">
                 <li class="menu-title" key="t-menu">Menu</li>
                 @hasanyrole('Super Admin|Admin')
                 {{-- Organization Manage --}}
                   <li class="menu-title mt-3" key="t-more">@lang('Dashboard')</li>
                   <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class='bx bxs-dashboard'></i>
                         <span key="t-dashboard">@lang('Dashboard')</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{ route('dashboard.main') }}"><span
                                     key="t-crypto">@lang('Main Dashboard')</span></a></li>
                         <li><a href="{{ route('dashboard.report') }}"><span
                                     key="t-crypto">@lang('Report Dashboard')</span></a></li>
                     </ul>
                    </li>
                 {{-- Organization Manage --}}
                   <li class="menu-title mt-3" key="t-more">@lang('Organization Manage')</li>
                   <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class='fas fa-industry'></i>
                         <span key="t-dashboard">@lang('Organization')</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{ route('organization.create_form') }}"><span
                                     key="t-crypto">@lang('Create Organization')</span></a></li>
                         <li><a href="{{ route('organization.search') }}"><span
                                     key="t-crypto">@lang('Search Organization')</span></a></li>
                         <!--<li><a href="#"><span key="t-crypto">@lang('Contract')</span></a>
                        <ul class="sub-menu" aria-expanded="false">
                        </ul>
                    </li>-->
                     </ul>
                     </li>
                 
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class='fas fa-users'></i>
                         <span key="t-dashboard">@lang('Members')</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{ route('organization.members.show') }}"><span
                                     key="t-calendar">@lang('Search Member')</span></a></li>
                         <li><a href="{{ route('organization.members.create') }}"><span
                                     key="t-calendar">@lang('Create Member')</span></a></li>
                         <li><a href="{{ route('organization.members.bulkUploadForm') }}"><span
                                     key="t-calendar">@lang('Bulk Upload')</span></a></li>
                         <li><a href="{{ route('organization.members.bulkDownloadForm') }}"><span
                                     key="t-calendar">@lang('Bulk Download')</span></a></li>
                     </ul>
                 </li>
                 {{-- <li>
                    <a href="{{ route('collection.add') }}" class="has-arrow waves-effect">
                        <i class='fas fa-file-alt'></i>
                        <span key="t-dashboard">Report</span>
                    </a>
                </li> --}}
                 @endhasanyrole
                 {{-- Account Part Manage --}}
                 @hasanyrole('Super Admin|Account Admin')
                 <li class="menu-title mt-3" key="t-more">@lang('Accounting Manage')</li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class='fas fa-file-invoice-dollar'></i>
                         <span key="t-dashboard">@lang('Collection')</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{ route('dashboard.main') }}"><span
                                     key="t-calendar">@lang('Account Dashboard')</span></a></li>
                        <li><a href="{{ route('collection.report') }}"><span
                                    key="t-calendar">@lang('Report Total Payment')</span></a></li>
                         <li><a href="{{ route('collection.add') }}"><span
                                     key="t-calendar">@lang('Add Collection')</span></a></li>
                         <li><a href="{{ route('collection.due') }}"><span
                            key="t-calendar">@lang('Due Collections')</span></a></li>
                        <li><a href="{{ route('collection.advise') }}"><span
                            key="t-calendar">@lang('Make Payment')</span></a></li>
                        <li><a href="{{ route('collection.due.death.payment') }}"><span
                            key="t-calendar">@lang('Due Death Payment')</span></a></li>
                        <li><a href="{{ route('collection.due.planA.payment') }}"><span
                            key="t-calendar">@lang('Due PlanA Payment')</span></a></li>
                        {{-- <li><a href="{{ route('collection.total.death.payment') }}"><span
                            key="t-calendar">@lang('Total Death Payment')</span></a></li>
                        <li><a href="{{ route('collection.total.planA.payment') }}"><span
                            key="t-calendar">@lang('Total PlanA Payment')</span></a></li> --}}
                        <li><a href="{{ route('collection.advise.download') }}"><span
                            key="t-calendar">@lang('Download Advice')</span></a></li>
                        <li><a href="{{ route('collection.eft.return') }}"><span
                            key="t-calendar">@lang('Return EFT')</span></a></li>
                        <li><a href="{{ route('collection.eft.underprocess') }}"><span
                            key="t-calendar">@lang('Underprocess Return EFT')</span></a></li>
                         <li><a href="{{ route('collection.claim.approved') }}"><span
                                     key="t-calendar">@lang('Apporved EFT Returns')</span></a></li>
                     </ul>
                 </li>
                 @endhasanyrole
                 {{-- Claims Manage --}}
                 @hasanyrole('Super Admin|Operator|Doctor|Claim Officer|Claim HOD|COO|CEO')
                 <li class="menu-title mt-3" key="t-more">@lang('Claims')</li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class='fas fa-tasks'></i>
                         <span key="t-dashboard">@lang('Claims')</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                        @hasanyrole('Super Admin|Operator')
                         <li><a href="{{ route('claims.index') }}"><span 
                                key="t-calendar">@lang('Intimate a claim')</span></a> </li>
                                    @endhasanyrole
                        @hasanyrole('Super Admin|Operator')
                         <li><a href="{{ route('claims.doc_required_index') }}"><span 
                                key="t-calendar">@lang('Document Required')</span></a> </li>
                                    @endhasanyrole
                        @hasanyrole('Super Admin|Operator')
                         <li><a href="{{ route('claims.eft.return') }}"><span 
                                key="t-calendar">@lang('EFT Return')</span></a> </li>
                                    @endhasanyrole
                        @hasanyrole('Super Admin|Claim Officer|Doctor|Claim HOD|COO|CEO')
                        <li><a href="{{ route('dashboard.main') }}"><span
                                    key="t-crypto">@lang('Claim Dashboard')</span></a></li>
                                    @endhasanyrole
                        @hasanyrole('Super Admin|Claim Officer')
                        <li><a href="{{ route('claims.report') }}"><span
                                    key="t-calendar">@lang('Claim report')</span></a></li>
                                    @endhasanyrole
                        @hasanyrole('Super Admin|Claim Officer')
                        <li><a href="{{ route('claims.underprocessing') }}"><span
                                    key="t-calendar">@lang('Under processing')</span></a></li>
                                    @endhasanyrole
                        @hasanyrole('Super Admin|Claim Officer')
                        <li><a href="{{ route('claims.document.required') }}"><span
                                    key="t-calendar">@lang('Document required')</span></a></li>
                                    @endhasanyrole
                        @hasanyrole('Super Admin|Claim Officer')
                         <li><a href="{{ route('claims.process') }}"><span
                                     key="t-calendar">@lang('Process claim')</span></a></li>
                                     @endhasanyrole

                        @hasanyrole('Super Admin|Doctor|Claim HOD|COO|CEO')
                         <li><a href="{{ route('claims.pending') }}"><span
                                     key="t-calendar">@lang('Pending for approval')</span></a></li>
                                     @endhasanyrole
                        @hasanyrole('Super Admin|Doctor|Claim HOD|COO')
                         <li><a href="{{ route('claims.rivew') }}"><span
                                     key="t-calendar">@lang('Asked for rivew')</span></a></li>
                                     @endhasanyrole
                     </ul>
                 </li>
                 @endhasanyrole
                 {{-- Settings Manage --}}
                 @hasanyrole('Super Admin|Account Admin')
                 <li class="menu-title mt-3" key="t-more">@lang('Settings manage')</li>
                 <li>
                     <a href="{{ route('setting.payment-methods.index') }}" class="waves-effect">
                         <i class="fab fa-cc-mastercard"></i>
                         <span key="t-charts">@lang('Payment Methods')</span>
                     </a>
                 </li> 
                 @endhasanyrole
                 {{-- Contract Manage --}}
                 @hasanyrole('Super Admin|Admin')
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class='fas fa-file-alt'></i>
                         <span key="t-dashboard">@lang('Contract')</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{ route('organization.contract.create') }}"><span
                                     key="t-crypto">@lang('Create Contract')</span></a></li>
                         <li><a href="{{ route('organization.contract.index') }}"><span
                                     key="t-crypto">@lang('Search Contract')</span></a></li>
                     </ul>
                 </li>
                 @endhasanyrole
                 @hasrole('Super Admin')
                     {{-- User Manage --}}
                     <li class="menu-title mt-3" key="t-more">User Manage</li>

                     <li>
                         <a href="javascript: void(0);" class="has-arrow waves-effect">
                             <i class='fas fa-user-cog'></i>
                             <span key="t-dashboard">Users</span>
                         </a>
                         <ul class="sub-menu" aria-expanded="false">
                             <li><a href="{{ route('user.index') }}"><span key="t-calendar">Users</span></a></li>
                             <li><a href="{{ route('user.create') }}"><span key="t-crypto">Create User</span></a>
                             </li>
                         </ul>
                     </li>

                     <li>
                         <a href="javascript: void(0);" class="has-arrow waves-effect">
                             <i class='fas fa-user-cog'></i>
                             <span key="t-dashboard">Roles</span>
                         </a>
                         <ul class="sub-menu" aria-expanded="false">
                             <li><a href="{{ route('role.index') }}"><span key="t-calendar">Roles</span></a></li>
                             <li><a href="{{ route('role.create') }}"><span key="t-crypto">Create Role</span></a></li>
                         </ul>
                     </li>
                 @endhasrole

             </ul>
         </div>
         <!-- Sidebar -->
     </div>
 </div>
 <!-- Left Sidebar End -->
