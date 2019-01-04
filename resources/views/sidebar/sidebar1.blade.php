
<aside class="main-sidebar">
        <section class="sidebar">
          <ul class="sidebar-menu">

              @if(Auth::User()->can('CanSeeDashBoardMenu'))

              <li class="treeview">

              <li class="{!! $dashboardActive or ''!!}">
                  <a href="{{url('/home')}}">
                      <i class="fa fa-dashboard"></i>
                      Dashboard
                  </a>
              </li>

              </li>
               @endif

                  @if(Auth::User()->can('CanSeeAdvanceLevelMenu'))
                      <li class="treeview {{ $classItems['ALActive'] or '' }}">
                          <a href="#">
                              <i class="fa fa-folder"></i> <span>A/L</span>
                              <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          <ul class="treeview-menu">

                              @if(Auth::User()->can('CanSeeAdvanceLevelStreamsMenu'))
                                  <li class="{{ $classItems['streamActive'] or '' }}">
                                      <a href="#">
                                          <i class="fa fa-circle-o"></i><span>Stream</span>
                                      </a>
                                      <ul class="treeview-menu">
                                          @if(Auth::User()->can('CanAddAdvanceLevelStream'))
                                              <li class="{{ $classItems['createStreamActive'] or '' }}">
                                                  <a href="{{ url('/streams/create') }}">
                                                      <i class="fa fa-circle-o"></i><span>Add</span>
                                                  </a>
                                              </li>
                                          @endif
                                          @if(Auth::User()->can('CanManageAdvanceLevelStream'))
                                          <li class="{{ $classItems['manageStreamActive'] or '' }}">
                                              <a href="{{ url('/streams') }}">
                                                  <i class="fa fa-circle-o"></i><span>Manage</span>
                                              </a>
                                          </li>
                                          @endif
                                              @if(Auth::User()->can('CanSeeDeletedAdvanceLevelStreams'))
                                              <li class="{{ $classItems['deletedStreamActive'] or '' }}">
                                                  <a href="{{ url('/activities/deleted/ALStream') }}">
                                                      <i class="fa fa-circle-o"></i><span>Deleted Streams</span>
                                                  </a>
                                              </li>
                                              @endif
                                      </ul>
                                   </li>
                              @endif

                           </ul>
                          <ul class="treeview-menu">

                              @if(Auth::User()->can('CanSeeAdvanceLevelSubjectsMenu'))
                                  <li class="{{ $classItems['alsubjectActive'] or '' }}">
                                      <a href="#">
                                          <i class="fa fa-circle-o"></i><span>Subjects</span>
                                      </a>
                                      <ul class="treeview-menu">
                                          @if(Auth::User()->can('CanAddAdvanceLevelSubjects'))
                                          <li class="{{ $classItems['createALSubjectActive'] or '' }}">
                                              <a href="{{ url('/alsubjects/create') }}">
                                                  <i class="fa fa-circle-o"></i><span>Add</span>
                                              </a>
                                          </li>
                                          @endif
                                          @if(Auth::User()->can('CanManageAdvanceLevelSubjects'))
                                          <li class="{{ $classItems['manageALSubjectActive'] or '' }}">
                                              <a href="{{ url('/alsubjects') }}">
                                                  <i class="fa fa-circle-o"></i><span>Manage</span>
                                              </a>
                                          </li>
                                          @endif
                                          @if(Auth::User()->can('CanSeeDeletedAdvanceLevelSubjects'))
                                          <li class="{{ $classItems['deletedALSubjectActive'] or '' }}">
                                              <a href="{{ url('/activities/deleted/ALSubject') }}">
                                                  <i class="fa fa-circle-o"></i><span>Deleted Subjects</span>
                                              </a>
                                          </li>
                                          @endif
                                      </ul>
                                  </li>
                              @endif

                          </ul>
                      </li>

                  @endif
                  @if(Auth::User()->can('CanSeeDistrictsMenu'))
                  <li class="treeview {{ $classItems['districtActive'] or ''}}">
                      <a href="#">
                          <i class="fa fa-folder"></i> <span>Districts</span>
                          <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                          @if(Auth::User()->can('CanAddDistricts'))
                          <li class="{{ $classItems['createDistrictActive'] or '' }}"><a href="{{ url('/districts/create') }}"><i class="fa fa-circle-o"></i> Add District</a></li>
                          @endif
                          @if(Auth::User()->can('CanManageDistricts'))
                          <li class="{{ $classItems['manageDistrictActive'] or '' }}"><a href="{{ url('/districts') }}"><i class="fa fa-circle-o"></i>Manage District</a></li>
                          @endif
                          @if(Auth::User()->can('CanSeeDeletedDistricts'))
                              <li class="{{ $classItems['deletedDistrictActive'] or '' }}"><a href="{{ url('/activities/deleted/District') }}"><i class="fa fa-circle-o"></i>Deleted Districts</a></li>
                          @endif
                      </ul>
                  </li>
                  @endif
                  @if(Auth::User()->can('CanSeeFacultiesMenu'))
                  <li class="treeview {{ $classItems['facultyActive'] or ''}}">
                      <a href="#">
                          <i class="fa fa-folder"></i> <span>Faculties</span>
                          <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                          @if(Auth::User()->can('CanAddFaculties'))
                          <li class="{{ $classItems['createFacultyActive'] or '' }}"><a href="{{ url('/faculties/create') }}"><i class="fa fa-circle-o"></i> Add Faculty</a></li>
                          @endif
                              @if(Auth::User()->can('CanManageFaculties'))
                              <li class="{{ $classItems['manageFacultyActive'] or '' }}"><a href="{{ url('/faculties') }}"><i class="fa fa-circle-o"></i>Manage Faculty</a></li>
                          @endif
                              @if(Auth::User()->can('CanSeeDeletedFaculties'))
                                  <li class="{{ $classItems['deletedFacultyActive'] or '' }}"><a href="{{ url('/activities/deleted/Faculty') }}"><i class="fa fa-circle-o"></i>Deleted Faculties</a></li>
                              @endif
                      </ul>
                  </li>
                @endif
                  @if(Auth::User()->can('CanSeeCoursesMenu'))
              <li class="treeview {{ $classItems['courseActive'] or ''}}">
              <a href="#">
                  <i class="fa fa-folder"></i> <span>Courses</span>
                  <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  @if(Auth::User()->can('CanAddCourses'))
                  <li class="{{ $classItems['createCourseActive'] or '' }}"><a href="{{ url('/courses/create') }}"><i class="fa fa-circle-o"></i> Add Course</a></li>
                  @endif
                      @if(Auth::User()->can('CanManageCourses'))
                      <li class="{{ $classItems['manageCourseActive'] or '' }}"><a href="{{ url('/courses') }}"><i class="fa fa-circle-o"></i>Manage Course</a></li>
                  @endif
                      @if(Auth::User()->can('CanSeeDeletedCourses'))
                          <li class="{{ $classItems['deletedCourseActive'] or '' }}"><a href="{{ url('/activities/deleted/Course') }}"><i class="fa fa-circle-o"></i>Deleted Courses</a></li>
                      @endif
              </ul>
              </li>
              @endif
                  @if(Auth::User()->can('CanSeeDepartmentsMenu'))
              <li class="treeview {{ $classItems['departmentActive'] or ''}}">
                  <a href="#">
                      <i class="fa fa-folder"></i> <span>Deprtments</span>
                      <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                      @if(Auth::User()->can('CanAddDepartments'))
                      <li class="{{ $classItems['createDepartmentActive'] or '' }}"><a href="{{ url('/departments/create') }}"><i class="fa fa-circle-o"></i> Add Department</a></li>
                      @endif
                          @if(Auth::User()->can('CanManageDepartments'))
                          <li class="{{ $classItems['manageDepartmentActive'] or '' }}"><a href="{{ url('/departments') }}"><i class="fa fa-circle-o"></i>Manage Department</a></li>
                          @endif
                          @if(Auth::User()->can('CanSeeDeletedDepartments'))
                              <li class="{{ $classItems['deletedDepartmentActive'] or '' }}"><a href="{{ url('/activities/deleted/Department') }}"><i class="fa fa-circle-o"></i>Deleted Departments</a></li>
                          @endif
                  </ul>
              </li>
                @endif
                  @if(Auth::User()->can('CanSeeRolesMenu'))
              <li class="treeview {{ $classItems['roleActive'] or ''}}">
                  <a href="#">
                      <i class="fa fa-folder"></i> <span>Roles</span>
                      <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                      @if(Auth::User()->can('CanAddRoles'))
                      <li class="{{ $classItems['createRoleActive'] or '' }}"><a href="{{ url('/roles/create') }}"><i class="fa fa-circle-o"></i> Add Role</a></li>
                      @endif
                          @if(Auth::User()->can('CanManageRoles'))
                          <li class="{{ $classItems['manageRoleActive'] or '' }}"><a href="{{ url('/roles') }}"><i class="fa fa-circle-o"></i>Manage Role</a></li>
                          @endif
                          @if(Auth::User()->can('CanSeeDeletedRoles'))
                              <li class="{{ $classItems['deletedRoleActive'] or '' }}"><a href="{{ url('/activities/deleted/Role') }}"><i class="fa fa-circle-o"></i>Deleted Roles</a></li>
                          @endif
                  </ul>
              </li>
                @endif
                  @if(Auth::User()->can('CanSeePermissionsMenu'))
              <li class="treeview {{ $classItems['permissionActive'] or ''}}">
                  <a href="#">
                      <i class="fa fa-folder"></i> <span>Permissions</span>
                      <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                      @if(Auth::User()->can('CanAddPermissions'))
                      <li class="{{ $classItems['createPermissionActive'] or '' }}"><a href="{{ url('/permissions/create') }}"><i class="fa fa-circle-o"></i> Add Permission</a></li>
                      @endif
                          @if(Auth::User()->can('CanManagePermissions'))
                          <li class="{{ $classItems['managePermissionActive'] or '' }}"><a href="{{ url('/permissions') }}"><i class="fa fa-circle-o"></i>Manage Permission</a></li>
                          @endif
                          @if(Auth::User()->can('CanSeeDeletedPermissions'))
                              <li class="{{ $classItems['deletedPermissionActive'] or '' }}"><a href="{{ url('/activities/deleted/Permission') }}"><i class="fa fa-circle-o"></i>Deleted Permissions</a></li>
                          @endif
                  </ul>
              </li>
                  @endif
                  @if(Auth::User()->can('CanSeeRolePermissionMenu'))
              <li class="treeview {{ $classItems['permissionRoleActive'] or '' }} ">
                  <a href="#">
                      <i class="fa fa-folder"></i> <span>Role Permissions</span>
                      <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                      @if(Auth::User()->can('CanAssignRolePermissions'))
                      <li class="{!! $classItems['createPermissionRoleActive'] or '' !!}"><a href="{{ url('/permissionrole/create') }}"><i class="fa fa-circle-o"></i>Assign Permission</a></li>
                      @endif
                          @if(Auth::User()->can('CanManageAssignedPermissions'))
                          <li class="{!! $classItems['managePermissionRoleActive'] or '' !!}"><a href="{{ url('/permissionrole') }}"><i class="fa fa-circle-o"></i>Manage Assigned Permission</a></li>
                          @endif
                          @if(Auth::User()->can('CanSeeDeletedRoleAssignedPermissions'))
                              <li class="{{ $classItems['deletedPermissionRoleActive'] or '' }}"><a href="{{ url('/activities/deleted/PermissionRole') }}"><i class="fa fa-circle-o"></i>Deleted Role Assigned Permission</a></li>
                          @endif
                  </ul>
              </li>
                @endif
                  @if(Auth::User()->can('CanSeeBatchesMenu'))
              <li class="treeview {{ $classItems['batchActive'] or ''}}">
                  <a href="#">
                      <i class="fa fa-folder"></i> <span>Batches</span>
                      <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                      @if(Auth::User()->can('CanAddBatches'))
                      <li class="{{ $classItems['createBatchActive'] or '' }}"><a href="{{ url('/batches/create') }}"><i class="fa fa-circle-o"></i> Add Batch</a></li>
                      @endif
                          @if(Auth::User()->can('CanManageBatches'))
                          <li class="{{ $classItems['manageBatchActive'] or '' }}"><a href="{{ url('/batches') }}"><i class="fa fa-circle-o"></i>Manage Batch</a></li>
                          @endif
                          @if(Auth::User()->can('CanSeeDeletedBatches'))
                              <li class="{{ $classItems['deletedBatchActive'] or '' }}"><a href="{{ url('/activities/deleted/Batch') }}"><i class="fa fa-circle-o"></i>Deleted Batches</a></li>
                          @endif
                  </ul>
              </li>
                @endif
                  @if(Auth::User()->can('CanSeeUsersMenu'))
       <li class="treeview {{ $classItems['userActive'] or '' }}">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Users</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  @if(Auth::User()->can('CanAddUsers'))
                <li class="{{ $classItems['registerUserActive'] or '' }}"><a href="{{ url('/register') }}"><i class="fa fa-circle-o"></i> Register</a></li>
                  @endif
                      @if(Auth::User()->can('CanManageUsers'))
                      <li class="{{ $classItems['manageUserActive'] or '' }}"><a href="{{ url('/users') }}"><i class="fa fa-circle-o"></i> Manage</a></li>
                      @endif
              </ul>
            </li>
                  @endif



                  @if(Auth::User()->can('CanSeeUniSubjectsMenu'))
              <li class="treeview {{ $classItems['uniSubjectActive'] or '' }} ">
                  <a href="#">
                      <i class="fa fa-folder"></i> <span>Subjects</span>
                      <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                      @if(Auth::User()->can('CanAddUniSubjects'))
                      <li class="{!! $classItems['createUniSubjectActive'] or '' !!}"><a href="{{ url('/unisubjects/create') }}"><i class="fa fa-circle-o"></i>Add Subject</a></li>
                      @endif
                          @if(Auth::User()->can('CanManageUniSubjects'))
                          <li class="{!! $classItems['manageUniSubjectActive'] or '' !!}"><a href="{{ url('/unisubjects') }}"><i class="fa fa-circle-o"></i>Manage Subjects</a></li>
                          @endif
                          @if(Auth::User()->can('CanSeeDeletedUniSubjects'))
                      <li class="{{ $classItems['deletedUniSubjectActive'] or '' }}"><a href="{{ url('/activities/deleted/UniSubject') }}"><i class="fa fa-circle-o"></i>Deleted Subjects</a></li>
                          @endif
                  </ul>
              </li>
                @endif

                  @if(Auth::User()->can('CanSeeStudentsMenu'))
              <li class="treeview {{ $classItems['studentActive'] or '' }} ">
                  <a href="#">
                      <i class="fa fa-folder"></i> <span>Students</span>
                      <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                      @if(Auth::User()->can('CanAddStudents'))
                      <li class="{!! $classItems['createStudentActive'] or '' !!}"><a href="{{ url('/students/create') }}"><i class="fa fa-circle-o"></i>Add Student</a></li>
                      @endif
                          @if(Auth::User()->can('CanManageStudents'))
                          <li class="{!! $classItems['manageStudentActive'] or '' !!}"><a href="{{ url('/students') }}"><i class="fa fa-circle-o"></i>Manage Students</a></li>
                          @endif
                          @if(Auth::User()->can('CanSeeDeletedStudents'))
                      <li class="{{ $classItems['deletedStudentActive'] or '' }}"><a href="{{ url('/activities/deleted/Student') }}"><i class="fa fa-circle-o"></i>Deleted Students</a></li>
                          @endif
                  </ul>
              </li>
                @endif
                  @if(Auth::User()->can('CanSeeStudentUniSubjectsMenu'))
              <li class="treeview {{ $classItems['studentUniSubjectActive'] or '' }} ">
                  <a href="#">

                      <i class="fa fa-folder"></i> <span>StudentsUniSubject</span>
                      <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                      @if(Auth::User()->can('CanAssignUniSubjects'))
                      <li class="{!! $classItems['createStudentUniSubjectActive'] or '' !!}"><a href="{{ url('/studentunisubject/create') }}"><i class="fa fa-circle-o"></i>Assign Subjects</a></li>
                      @endif
                          @if(Auth::User()->can('CanManageAssignedSubjects'))
                          <li class="{!! $classItems['manageStudentUniSubjectActive'] or '' !!}"><a href="{{ url('/studentunisubject') }}"><i class="fa fa-circle-o"></i>Manage Assigned Subjects</a></li>
                          @endif
                          @if(Auth::User()->can('CanSeeDeletedAssignedSubjects'))
                      <li class="{{ $classItems['deletedStudentUniSubjectActive'] or '' }}"><a href="{{ url('/activities/deleted/StudentUniSubject') }}"><i class="fa fa-circle-o"></i>Deleted Assigned Subjects</a></li>
                          @endif
                  </ul>
              </li>
                  @endif
                  @if(Auth::User()->can('CanSeeAttendanceManagementMenu'))
              <li class="treeview {{ $classItems['attendanceActive'] or '' }} ">
                  <a href="#">
                      <i class="fa fa-folder"></i> <span>Attendance Management</span>
                      <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                      @if(Auth::User()->can('CanGenerateAttendanceSheet'))
                      <li class="{!! $classItems['generateAttendanceSheetActive'] or '' !!}"><a href="{{ url('/generatesheet') }}"><i class="fa fa-circle-o"></i>Generate Sheet</a></li>
                      @endif
                          @if(Auth::User()->can('CanGenerateSubjectWiseAttendance'))
                          <li class="{!! $classItems['subjectAttendanceActive'] or '' !!}"><a href="{{ url('/generatsubjectattendance') }}"><i class="fa fa-circle-o"></i>Subject Wise Attendance</a></li>
                          @endif
                          @if(Auth::User()->can('CanAddAttendance'))
                              <li class="{!! $classItems['createAttendanceActive'] or '' !!}"><a href="{{ url('/bulkattendances/create') }}"><i class="fa fa-circle-o"></i>Mark Attendance</a></li>
                          @endif
                          @if(Auth::User()->can('CanManageAttendance'))
                              <li class="{!! $classItems['manageAttendanceActive'] or '' !!}"><a href="{{ url('/attendances') }}"><i class="fa fa-circle-o"></i>Manage Attendance</a></li>
                          @endif
                          @if(Auth::User()->can('CanSeeDeletedAttendance'))
                      <li class="{{ $classItems['deletedAttendanceActive'] or '' }}"><a href="{{ url('/activities/deleted/Attendance') }}"><i class="fa fa-circle-o"></i>Deleted Attendance</a></li>
                          @endif
                  </ul>
              </li>
                  @endif
                  @if(Auth::User()->can('CanSeeLecturesManagementMenu'))
              <li class="treeview {{ $classItems['lectureActive'] or '' }} ">
                  <a href="#">
                      <i class="fa fa-folder"></i> <span>Lectures Management</span>
                      <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                      @if(Auth::User()->can('CanSeeLectureSummary'))
                      <li class="{!! $classItems['viewSummaryActive'] or '' !!}"><a href="{{ url('/viewlecturesummary') }}"><i class="fa fa-circle-o"></i>View Summary</a></li>
                              @endif
                          @if(Auth::User()->can('CanSeeICTAttendance'))
                              <li class="{!! $classItems['ictActive'] or '' !!}"><a href="{{ url('/studentelicount') }}"><i class="fa fa-circle-o"></i>ICT Attendance</a></li>
                          @endif
                  </ul>
              </li>
                @endif
          </ul>
        </section>
      </aside>