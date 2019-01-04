<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">

    <ul class="nav menu">
        <li class="{{ $dashboardActive or '' }}">
            <a href="{{url('/home')}}">
                <i class="fa fa-tachometer fa-fw" aria-hidden="true"></i> Dashboard
            </a>
        </li>

        <li class="parent">

            <a class="{{ $classItems['masterDataActive'] or '' }}" href="#">
                <span data-toggle="collapse" href="#masterdata">
                    <i class="fa fa-shield" aria-hidden="true"></i> Master Data
                </span>
            </a>

            <ul class="children collapse {{ $classItems['masterIn'] or '' }}" id="masterdata">

                <li>
                    <a class="{{ $classItems['userDataActive'] or '' }}" href="#">
                        <span data-toggle="collapse" href="#userdata">
                            <i class="fa fa-users" aria-hidden="true"></i> User
                        </span>
                    </a>
                    <ul style="margin-left:25px;" class="children collapse {{ $classItems['userDataIn'] or '' }}" id="userdata">

                            <li>
                                <a class="{{ $classItems['registerUserActive'] or '' }}" href="{{ url('/register') }}">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i> Add
                                </a>
                            </li>

                            <li>
                                <a class="{{ $classItems['manageUserActive'] or '' }}" href="{{ url('/users') }}">
                                    <i class="fa fa-eye" aria-hidden="true"></i> Manage
                                </a>
                            </li>

                            <li>

                                <a class="{{ $classItems['roleActive'] or '' }}" href="#">
                                    <span data-toggle="collapse" href="#roles">
                                        <i class="fa fa-user-secret" aria-hidden="true"></i> Roles
                                    </span>
                                </a>
                                <ul style="margin-left:25px;" class="children collapse {{ $classItems['roleIn'] or '' }}" id="roles">
                                    <li>
                                        <a class="{{ $classItems['createRoleActive'] or '' }}" href="{{ url('/roles/create') }}">
                                            <i class="fa fa-plus-square" aria-hidden="true"></i> Add
                                        </a>
                                    </li>

                                    <li>
                                        <a class="{{ $classItems['manageRoleActive'] or '' }}" href="{{ url('/roles') }}">
                                            <i class="fa fa-eye" aria-hidden="true"></i> Manage
                                        </a>
                                    </li>

                                    <li>
                                        <a class="{{ $classItems['deletedRoleActive'] or '' }}" href="{{ url('/activities/deleted/Role') }}">
                                            <i class="fa fa-trash" aria-hidden="true"></i> Deleted
                                        </a>
                                    </li>

                                </ul>

                            </li>

                            <li>
                                <a class="{{ $classItems['permissionActive'] or '' }}" href="#">
                            <span data-toggle="collapse" href="#permissions">
                                <i class="fa fa-key" aria-hidden="true"></i> Permissions
                            </span>
                                </a>
                                <ul style="margin-left:25px;" class="children collapse {{ $classItems['permissionIn'] or '' }}" id="permissions">
                                    <li>
                                        <a class="{{ $classItems['createPermissionActive'] or '' }}" href="{{ url('/permissions/create') }}">
                                            <i class="fa fa-plus-square" aria-hidden="true"></i> Add
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ $classItems['managePermissionActive'] or '' }}" href="{{ url('/permissions') }}">
                                            <i class="fa fa-eye" aria-hidden="true"></i> Manage
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ $classItems['deletedPermissionActive'] or '' }}" href="{{ url('/activities/deleted/Permission') }}">
                                            <i class="fa fa-trash" aria-hidden="true"></i> Deleted
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a class="{{ $classItems['permissionRoleActive'] or '' }}" href="#">
                                    <span data-toggle="collapse" href="#permissionrole">
                                        <i class="fa fa-wrench" aria-hidden="true"></i> Permission Role
                                    </span>
                                </a>
                                <ul style="margin-left:25px;" class="children collapse {{ $classItems['permissionRoleIn'] or '' }}" id="permissionrole">
                                    <li>
                                        <a class="{{ $classItems['createPermissionRoleActive'] or '' }}" href="{{ url('/permissionrole/create') }}">
                                            <i class="fa fa-plus-square" aria-hidden="true"></i> Assign
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ $classItems['managePermissionRoleActive'] or '' }}" href="{{ url('/permissionrole') }}">
                                            <i class="fa fa-eye" aria-hidden="true"></i> Manage
                                        </a>
                                    </li>
                                    <li>
                                        <a class="{{ $classItems['deletedPermissionRoleActive'] or '' }}" href="{{ url('/activities/deleted/PermissionRole') }}">
                                            <i class="fa fa-trash" aria-hidden="true"></i> Deleted
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        <li>

                            <a class="{{ $classItems['salesTargetActive'] or '' }}" href="#">
                                    <span data-toggle="collapse" href="#salestarget">
                                        <i class="fa fa-transgender-alt" aria-hidden="true"></i> Sales Target
                                    </span>
                            </a>
                            <ul style="margin-left:25px;" class="children collapse {{ $classItems['salesTargetIn'] or '' }}" id="salestarget">
                                <li>
                                    <a class="{{ $classItems['createSalesTargetActive'] or '' }}" href="{{ url('/salestarget/create') }}">
                                        <i class="fa fa-plus-square" aria-hidden="true"></i> Add
                                    </a>
                                </li>

                                <li>
                                    <a class="{{ $classItems['manageSalesTargetActive'] or '' }}" href="{{ url('/salestarget') }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i> Manage
                                    </a>
                                </li>

                                {{--<li>--}}
                                    {{--<a class="{{ $classItems['deletedSalesTargetActive'] or '' }}" href="{{ url('/activities/deleted/Role') }}">--}}
                                        {{--<i class="fa fa-trash" aria-hidden="true"></i> Deleted--}}
                                    {{--</a>--}}
                                {{--</li>--}}

                            </ul>

                        </li>

                    </ul>

                </li>

                <li>
                    <a class="{{ $classItems['productDataActive'] or '' }}" href="#">
                        <span data-toggle="collapse" href="#productdata">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> Products
                        </span>
                    </a>

                    <ul style="margin-left:25px;" class="children collapse {{ $classItems['productDataIn'] or '' }}" id="productdata">

                        <li>
                            <a class="{{ $classItems['createProductActive'] or '' }}" href="{{ url('/products/create') }}">
                                <i class="fa fa-plus-square" aria-hidden="true"></i> Add
                            </a>
                        </li>
                        <li>
                            <a class="{{ $classItems['manageProductActive'] or '' }}" href="{{ url('/products') }}">
                                <i class="fa fa-eye" aria-hidden="true"></i> Manage
                            </a>
                        </li>
                        <li>
                            <a class="{{ $classItems['deletedProductActive'] or '' }}" href="{{ url('/activities/deleted/Product') }}">
                                <i class="fa fa-trash" aria-hidden="true"></i> Deleted
                            </a>
                        </li>

                        <li>
                            <a class="{{ $classItems['categoryActive'] or '' }}" href="#">
                                <span data-toggle="collapse" href="#categories">
                                    <i class="fa fa-tags" aria-hidden="true"></i> Categories
                                </span>
                            </a>
                            <ul style="margin-left:25px;" class="children collapse {{ $classItems['categoryIn'] or '' }}" id="categories">
                                <li>
                                    <a class="{{ $classItems['createCategoryActive'] or '' }}" href="{{ url('/categories/create') }}">
                                        <i class="fa fa-plus-square" aria-hidden="true"></i> Add
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ $classItems['manageCategoryActive'] or '' }}" href="{{ url('/categories') }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i> Manage
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ $classItems['deletedCategoryActive'] or '' }}" href="{{ url('/activities/deleted/Category') }}">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Deleted
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a class="{{ $classItems['brandActive'] or '' }}" href="#">
                                <span data-toggle="collapse" href="#brands">
                                    <i class="fa fa-dashcube" aria-hidden="true"></i> Brands
                                </span>
                            </a>
                            <ul style="margin-left:25px;" class="children collapse {{ $classItems['brandIn'] or '' }}" id="brands">
                                <li>
                                    <a class="{{ $classItems['createBrandActive'] or '' }}" href="{{ url('/brands/create') }}">
                                        <i class="fa fa-plus-square" aria-hidden="true"></i> Add
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ $classItems['manageBrandActive'] or '' }}" href="{{ url('/brands') }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i> Manage
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ $classItems['deletedBrandActive'] or '' }}" href="{{ url('/activities/deleted/Brand') }}">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Deleted
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>

                </li>

            </ul>
        </li>

        <li class="parent">

            <a class="{{ $classItems['salesInquiryActive'] or '' }}" href="#">
                <span data-toggle="collapse" href="#salesinquiry">
                    <i class="fa fa-briefcase" aria-hidden="true"></i> Sales And Inquiry
                </span>
            </a>

            <ul class="children collapse {{ $classItems['salesInquiryIn'] or '' }}" id="salesinquiry">
                <li>
                    <a class="{{ $classItems['createLeadOrInquiryActive'] or '' }}" href="{{ url('/leadorinquiry/create') }}">
                        <i class="fa fa-plus-square" aria-hidden="true"></i> Add
                    </a>
                </li>
                <li>
                    <a class="{{ $classItems['manageLeadActive'] or '' }}" href="{{ url('/leads') }}">
                        <i class="fa fa-eye" aria-hidden="true"></i> Manage Leads
                    </a>
                </li>
                <li>
                    <a class="{{ $classItems['manageInquiryActive'] or '' }}" href="{{ url('/inquiries') }}">
                        <i class="fa fa-eye" aria-hidden="true"></i> Manage Inquries
                    </a>
                </li>
            </ul>

        </li>

        <li class="parent">

            <a class="{{ $classItems['quotationActive'] or '' }}" href="#">
                <span data-toggle="collapse" href="#quotaion">
                    <i class="fa fa-shirtsinbulk" aria-hidden="true"></i> Quotations
                </span>
            </a>

            <ul class="children collapse {{ $classItems['quotationIn'] or '' }}" id="quotaion">

                <li>
                    <a class="{{ $classItems['manageQuotationActive'] or '' }}" href="{{ url('/quotations') }}">
                        <i class="fa fa-eye" aria-hidden="true"></i> Manage
                    </a>
                </li>
            </ul>

        </li>

        <li class="parent">

            <a class="{{ $classItems['jobActive'] or '' }}" href="#">
                <span data-toggle="collapse" href="#job">
                    <i class="fa fa-shirtsinbulk" aria-hidden="true"></i> Insatllation
                </span>
            </a>

            <ul class="children collapse {{ $classItems['jobIn'] or '' }}" id="job">

                <li>
                    <a class="{{ $classItems['manageJobActive'] or '' }}" href="{{ url('/jobs') }}">
                        <i class="fa fa-eye" aria-hidden="true"></i> Manage
                    </a>
                </li>
            </ul>

        </li>


    </ul>

</div>
