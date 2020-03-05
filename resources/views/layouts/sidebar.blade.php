<?php
	use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
    $level    			= session('level');

    (session('advert')) ? $advert = session('advert') : $advert = null;

 ?>
		<li class="sidebar-toggler-wrapper hide">
			<div class="sidebar-toggler">
				<span></span>
			</div>
		</li>
		@if($level == "Super Admin")
		<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
			<h3 class="uppercase" style="color: #10704e;font-weight: 600;">Home</h3>
		</li>
		<li class="nav-item {{($menu_active == 'home') ? 'active' : ''}}">
			<a href="{{url('home')}}" class="nav-link">
				<i class="icon-home"></i>
				<span class="title">Home</span>
			</a>
		</li>
		<li class="nav-item {{($menu_active == 'setting-home-user') ? 'active' : ''}}">
			<a href="{{url('setting/home/user')}}" class="nav-link">
				<i class="fa fa-cog "></i>
				<span class="title">Home Setting</span>
			</a>
		</li>
		@endif

		@if(MyHelper::hasAccess([2,4,7,9,148], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #10704e;font-weight: 600;">Accounts</h3>
			</li>
			<li class="nav-item {{($menu_active == 'user') ? 'active open' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-users"></i>
					<span class="title">User</span>
					<span class="arrow {{($menu_active == 'user') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([4], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'user-new') ? 'active open' : ''}}">
						<a href="{{url('user/create')}}" class="nav-link ">
							<span class="title">New User</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([2], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'user-list') ? 'active open' : ''}}">
						<a href="{{url('user')}}" class="nav-link ">
							<span class="title">User List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([7], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'user-log') ? 'active open' : ''}}">
						<a href="{{url('user/activity')}}" class="nav-link ">
							<span class="title">Log Activity</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([40], $configs))
						@if(MyHelper::hasAccess([91], $grantedFeature))
							@if(MyHelper::hasAccess([41], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-pin-sent') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/pin-sent')}}" class="nav-link ">
										<span class="title">[Response] Pin Sent</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([42], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-pin-verify') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/pin-verify')}}" class="nav-link ">
										<span class="title">[Response] Pin Verified</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([43], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-pin-changed') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/pin-changed')}}" class="nav-link ">
										<span class="title">[Response] Pin Changed First Time</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([43], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-pin-changed-forgot-password') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/pin-changed-forgot-password')}}" class="nav-link ">
										<span class="title">[Response] Pin Changed Forgot Password</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([83], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-pin-forgot') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/pin-forgot')}}" class="nav-link ">
										<span class="title">[Response] Pin Forgot</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([44], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-login-success') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/login-success')}}" class="nav-link ">
										<span class="title">[Response] Login Success</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([45], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-login-failed') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/login-failed')}}" class="nav-link ">
										<span class="title">[Response] Login Failed</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([43], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-login-first-time') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/login-first-time')}}" class="nav-link ">
										<span class="title">[Response] Login First Time</span>
									</a>
								</li>
							@endif
						@endif
					@endif
				</ul>
			</li>

			@if(MyHelper::hasAccess([5], $configs))
			<li class="nav-item {{($menu_active == 'admin-outlet') ? 'active open' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-eye"></i>
					<span class="title">Admin Outlet</span>
					<span class="arrow {{($menu_active == 'admin-outlet') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([4], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'admin-outlet-create') ? 'active open' : ''}}">
						<a href="{{url('user/adminoutlet/create')}}" class="nav-link ">
							<span class="title">New Admin Outlet</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([9], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'admin-outlet-list') ? 'active open' : ''}}">
						<a href="{{url('user/adminoutlet')}}" class="nav-link ">
							<span class="title">Admin Outlet List</span>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif

		@endif

		@if(MyHelper::hasAccess([20], $configs))
			@if(MyHelper::hasAccess([10,12], $grantedFeature))
			<li class="nav-item {{($menu_active == 'membership') ? 'active' : ''}}">
				<a href="{{url('membership')}}" class="nav-link">
					<i class="icon-badge"></i>
					<span class="title">Membership</span>
				</a>
			</li>
			@endif
		@endif

		@if($level == "Super Admin")
		<li class="nav-item {{($menu_active == 'expired-qrcode') ? 'active' : ''}}">
			<a href="{{url('setting/qrcode_expired')}}" class="nav-link">
				<i class="fa fa-qrcode"></i>
				<span class="title">Setting Expired QR Code</span>
			</a>
		</li>

		<li class="nav-item {{($menu_active == 'count-login-failed') ? 'active' : ''}}">
			<a href="{{url('setting/count_login_failed')}}" class="nav-link">
				<i class="fa fa-times-circle-o"></i>
				<span class="title">Setting Count Login Failed</span>
			</a>
		</li>

		@if(MyHelper::hasAccess([18], $configs))
			@if(MyHelper::hasAccess([77], $configs))
			<li class="nav-item {{($menu_active == 'point-reset') ? 'active' : ''}}">
				<a href="{{url('setting/point_reset')}}" class="nav-link">
					<i class="fa fa-refresh"></i>
					<span class="title">Setting Point Reset</span>
				</a>
			</li>
			@endif
		@endif

		@if(MyHelper::hasAccess([120,148], $grantedFeature))
		<li class="nav-item {{($menu_active == 'profile-completion') ? 'active open' : ''}}">
			<a href="javascript:;" class="nav-link nav-toggle">
				<i class="icon-users"></i>
				<span class="title">Profile Completion</span>
				<span class="arrow {{($menu_active == 'profile-completion') ? 'open' : ''}}"></span>
			</a>
			<ul class="sub-menu">
				@if(MyHelper::hasAccess([148], $grantedFeature))
				<li class="nav-item {{($submenu_active == 'complete-profile') ? 'active open' : ''}}">
					<a href="{{url('setting/complete-profile')}}" class="nav-link ">
						<span class="title">User Profile Completion</span>
					</a>
				</li>
				@endif
				@if(MyHelper::hasAccess([120], $grantedFeature))
				<li class="nav-item {{($submenu_active == 'complete-user-profile-point-bonus') ? 'active' : ''}}">
					<a href="{{url('user/autoresponse/complete-user-profile-point-bonus')}}" class="nav-link nav-toggle">
						<span class="title">[Response] User Profile Completion Point Bonus</span>
					</a>
				</li>
				@endif
			</ul>
		</li>
		@endif

		@if(MyHelper::hasAccess([19], $configs))
			@if(MyHelper::hasAccess([78], $configs))
			<li class="nav-item {{($menu_active == 'balance-reset') ? 'active' : ''}}">
				<a href="{{url('setting/balance_reset')}}" class="nav-link">
					<i class="fa fa-refresh"></i>
					<span class="title">Setting {{env('POINT_NAME', 'Points')}} Reset</span>
				</a>
			</li>
			@endif
		@endif

		@endif

		@if(MyHelper::hasAccess([19,21,24,26,32,33,34,43,45,48,50,56,57,164,165,166,167], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #10704e;font-weight: 600;">Browse</h3>
			</li>
			@if(MyHelper::hasAccess([34], $configs))
				@if(MyHelper::hasAccess([19,21,164,165,166,167], $grantedFeature))
				<li class="nav-item {{($menu_active == 'news') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-feed"></i>
						<span class="title">News</span>
						<span class="arrow {{($menu_active == 'news') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([21], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'news-new') ? 'active open' : ''}}">
							<a href="{{url('news/create')}}" class="nav-link ">
								<span class="title">New News</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([19], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'news-list') ? 'active open' : ''}}">
							<a href="{{url('news')}}" class="nav-link ">
								<span class="title">News List</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([164,166,167], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'news-category') ? 'active open' : ''}}">
							<a href="{{url('news/category')}}" class="nav-link ">
								<span class="title">News Category</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([165], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'news-category-new') ? 'active open' : ''}}">
							<a href="{{url('news/category/create')}}" class="nav-link ">
								<span class="title">New News Category</span>
							</a>
						</li>
						@endif
					</ul>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([97], $configs))
			@if(MyHelper::hasAccess([155,156,157,158,159], $grantedFeature))
			<li class="nav-item {{($menu_active == 'brand') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-badge"></i>
					<span class="title">Brand</span>
					<span class="arrow {{($menu_active == 'brand') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([156], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'brand-new') ? 'active open' : ''}}">
						<a href="{{url('brand/create')}}" class="nav-link ">
							<span class="title">New Brand</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([155,157,158,159], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'brand-list') ? 'active open' : ''}}">
						<a href="{{url('brand')}}" class="nav-link ">
							<span class="title">List Brand</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([157], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'inactive-brand-image') ? 'active open' : ''}}">
						<a href="{{url('brand/inactive-image')}}" class="nav-link ">
							<span class="title">Inactive Brand Image</span>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif
			@endif

			@if(MyHelper::hasAccess([24,26,32,33,34], $grantedFeature))
			<li class="nav-item {{($menu_active == 'outlet') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-pointer"></i>
					<span class="title">Outlet</span>
					<span class="arrow {{($menu_active == 'outlet') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(!MyHelper::hasAccess([82], $configs))
						@if(MyHelper::hasAccess([26], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'outlet-new') ? 'active open' : ''}}">
							<a href="{{url('outlet/create')}}" class="nav-link ">
								<span class="title">New Outlet</span>
							</a>
						</li>
						@endif
					@endif
					@if(MyHelper::hasAccess([24], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'outlet-list') ? 'active open' : ''}}">
						<a href="{{url('outlet/list')}}" class="nav-link ">
							<span class="title">Outlet List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([24], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'outlet-list-ovo') ? 'active open' : ''}}">
						<a href="{{url('outlet/ovo/list')}}" class="nav-link ">
							<span class="title">Outlet Ovo List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([24], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'outlet-qrcode') ? 'active open' : ''}}">
						<a href="{{url('outlet/qrcode')}}" class="nav-link ">
							<span class="title">QRCode Outlet</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([4], $configs))
						@if(MyHelper::hasAccess([34], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'outlet-holiday') ? 'active open' : ''}}">
							<a href="{{url('outlet/holiday')}}" class="nav-link ">
								<span class="title">Outlet Holiday Setting</span>
							</a>
						</li>
						@endif
					@endif
					@if(MyHelper::hasAccess([2], $configs) || MyHelper::hasAccess([3], $configs))
						@if(MyHelper::hasAccess([27], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'manage-location') ? 'active open' : ''}}">
							<a href="{{url('outlet/manage-location')}}" class="nav-link ">
								<span class="title">Manage Location</span>
							</a>
						</li>
						@endif
					@endif
					@if(MyHelper::hasAccess([2], $configs) || MyHelper::hasAccess([3], $configs))
						@if(MyHelper::hasAccess([32, 33], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'outlet-export-import') ? 'active open' : ''}}">
								<a href="{{url('outlet/export-import')}}" class="nav-link ">
									<span class="title">Export Import Outlet</span>
								</a>
							</li>
						@endif
					@endif
				</ul>
			</li>
			@endif

			@if(MyHelper::hasAccess([43,45,48,50,56,57], $grantedFeature))
			<li class="nav-item {{($menu_active == 'product') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-wallet"></i>
					<span class="title">Product</span>
					<span class="arrow {{($menu_active == 'product') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([45], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-category-new') ? 'active open' : ''}}">
						<a href="{{url('product/category/create')}}" class="nav-link ">
							<span class="title">New Category</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([43], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-category-list') ? 'active open' : ''}}">
						<a href="{{url('product/category')}}" class="nav-link ">
							<span class="title">Category List</span>
						</a>
					</li>
					@endif
					<!-- <li class="nav-item {{($submenu_active == 'product-tag-list') ? 'active open' : ''}}">
						<a href="{{url('product/tag')}}" class="nav-link ">
							<span class="title">Tag List</span>
						</a>
					</li> -->
					@if(!MyHelper::hasAccess([1], $configs))
						@if(MyHelper::hasAccess([50], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'product-new') ? 'active open' : ''}}">
							<a href="{{url('product/create')}}" class="nav-link ">
								<span class="title">New Product</span>
							</a>
						</li>
						@endif
					@endif
					<!--@if(MyHelper::hasAccess([10], $configs)|| MyHelper::hasAccess([11], $configs))-->
					<!--	@if(MyHelper::hasAccess([56,57], $grantedFeature))-->
					<!--	<li class="nav-item {{($submenu_active == 'product-import') ? 'active open' : ''}}">-->
					<!--		<a href="{{url('product/import')}}" class="nav-link ">-->
					<!--			<span class="title">Export & Import Product</span>-->
					<!--		</a>-->
					<!--	</li>-->
					<!--	@endif-->
					<!--@endif-->
					@if(MyHelper::hasAccess([48], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-list') ? 'active open' : ''}}">
						<a href="{{url('product')}}" class="nav-link ">
							<span class="title">Product List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([48], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-list-image') ? 'active open' : ''}}">
						<a href="{{url('product/image')}}" class="nav-link ">
							<span class="title">Image Product List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([48], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-list-visible') ? 'active open' : ''}}">
						<a href="{{url('product/visible')}}" class="nav-link ">
							<span class="title">Visible Product List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([48], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-list-hidden') ? 'active open' : ''}}">
						<a href="{{url('product/hidden')}}" class="nav-link ">
							<span class="title">Hidden Product List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([48], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-category') ? 'active open' : ''}}">
						<a href="{{url('product/category/assign')}}" class="nav-link ">
							<span class="title">Manage Product Category</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([48], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-position') ? 'active open' : ''}}">
						<a href="{{url('product/position/assign')}}" class="nav-link ">
							<span class="title">Manage Position</span>
						</a>
					</li>
					@endif
					<li class="nav-item {{($submenu_active == 'product-photo-default') ? 'active open' : ''}}">
						<a href="{{url('product/photo/default')}}" class="nav-link ">
							<span class="title">Product Photo Default</span>
						</a>
					</li>
				</ul>
			</li>
			@endif

			@if(MyHelper::hasAccess([1], $configs)&&MyHelper::hasAccess([1], $grantedFeature))
			<li class="nav-item {{($menu_active == 'product-variant') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="fa fa-object-group"></i>
					<span class="title">Complex Menu</span>
					<span class="arrow {{($menu_active == 'product-variant') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([1], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-group-new') ? 'active open' : ''}}">
						<a href="{{url('product-variant/group/create')}}" class="nav-link ">
							<span class="title">New Product Group</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([1], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-group-list') ? 'active open' : ''}}">
						<a href="{{url('product-variant/group')}}" class="nav-link ">
							<span class="title">Product Group List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([1], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'image-product-group-list') ? 'active open' : ''}}">
						<a href="{{url('product-variant/group/image')}}" class="nav-link ">
							<span class="title">Image Product Group List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([1], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-variant-new') ? 'active open' : ''}}">
						<a href="{{url('product-variant/create')}}" class="nav-link ">
							<span class="title">New Product Variant</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([1], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-variant-list') ? 'active open' : ''}}">
						<a href="{{url('product-variant')}}" class="nav-link ">
							<span class="title">Product Variant List</span>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif

			@if(MyHelper::hasAccess([91], $configs)&&MyHelper::hasAccess([185,186,187,188,189,190,191], $grantedFeature))
			<li class="nav-item {{($menu_active == 'product-modifier') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="fa fa-puzzle-piece"></i>
					<span class="title">Adds-on</span>
					<span class="arrow {{($menu_active == 'product-modifier') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([186], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-modifier-new') ? 'active open' : ''}}">
						<a href="{{url('product/modifier/create')}}" class="nav-link ">
							<span class="title">New Adds-on</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([185,187,188,189], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-modifier-list') ? 'active open' : ''}}">
						<a href="{{url('product/modifier')}}" class="nav-link ">
							<span class="title">Adds-on List</span>
						</a>
					</li>
					@endif
					<!-- <li class="nav-item {{($submenu_active == 'product-tag-list') ? 'active open' : ''}}">
						<a href="{{url('product/tag')}}" class="nav-link ">
							<span class="title">Tag List</span>
						</a>
					</li> -->
					@if(MyHelper::hasAccess([190,191], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-modifier-price') ? 'active open' : ''}}">
						<a href="{{url('product/modifier/price')}}" class="nav-link ">
							<span class="title">Adds-on Price</span>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif

		@endif

		@if(MyHelper::hasAccess([58,59,60,61,62,63,64,66,69,71,197,199], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #10704e;font-weight: 600;">Order</h3>
			</li>

			@if(MyHelper::hasAccess([69], $grantedFeature))
			<li class="nav-item {{($menu_active == 'transaction') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="fa fa-shopping-cart"></i>
					<span class="title">Product Transaction</span>
					<span class="arrow {{($menu_active == 'transaction') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([13], $configs))
					<li class="nav-item {{($submenu_active == 'transaction-delivery') ? 'active open' : ''}}">
						<a href="{{url('transaction/delivery/'.date('YmdHis'))}}" class="nav-link ">
							<span class="title">Delivery</span>
						</a>
					</li>
					@endif
					<li class="nav-item {{($submenu_active == 'transaction-offline') ? 'active open' : ''}}">
						<a href="{{url('transaction/offline/'.date('YmdHis'))}}" class="nav-link ">
							<span class="title">Offline</span>
						</a>
					</li>
					@if(MyHelper::hasAccess([12], $configs))
					<li class="nav-item {{($submenu_active == 'transaction-pickup order') ? 'active open' : ''}}">
						<a href="{{url('transaction/pickup order/'.date('YmdHis'))}}" class="nav-link ">
							<span class="title">Pickup Order</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([12, 13], $configs))
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-transaction-success') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/transaction-success')}}" class="nav-link ">
							<span class="title">[Response] Transaction Success</span>
						</a>
					</li>
					<!--<li class="nav-item {{($submenu_active == 'transaction-autoresponse-transaction-payment') ? 'active open' : ''}}">-->
					<!--	<a href="{{url('transaction/autoresponse/transaction-payment')}}" class="nav-link ">-->
					<!--		<span class="title">[Response] Transaction Payment</span>-->
					<!--	</a>-->
					<!--</li>-->
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-transaction-expired') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/transaction-expired')}}" class="nav-link ">
							<span class="title">[Response] Transaction Expired</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-order-accepted') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/order-accepted')}}" class="nav-link ">
							<span class="title">[Response] Order Accepted</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-order-ready') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/order-ready')}}" class="nav-link ">
							<span class="title">[Response] Order Ready</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-order-taken') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/order-taken')}}" class="nav-link ">
							<span class="title">[Response] Order Taken</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-order-reject') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/order-reject')}}" class="nav-link ">
							<span class="title">[Response] Order Rejected</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-cron-transaction') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/cron-transaction')}}" class="nav-link ">
							<span class="title">[Response] Cron Transaction</span>
						</a>
					</li>
					@endif
					<li class="nav-item {{($submenu_active == 'transaction-point-achievement') ? 'active' : ''}}">
						<a href="{{url('transaction/autoresponse/transaction-point-achievement')}}" class="nav-link nav-toggle">
							<span class="title">[Response] Transaction Point Achievement</span>
						</a>
					</li>
					@if(MyHelper::hasAccess([12, 13], $configs))
					<li class="nav-item {{($submenu_active == 'transaction-failed-point-refund') ? 'active' : ''}}">
						<a href="{{url('transaction/autoresponse/transaction-failed-point-refund')}}" class="nav-link nav-toggle">
							<span class="title">[Response] Transaction Failed Point Refund</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'rejected-order-point-refund') ? 'active' : ''}}">
						<a href="{{url('transaction/autoresponse/rejected-order-point-refund')}}" class="nav-link nav-toggle">
							<span class="title">[Response] Rejected Order Point Refund</span>
						</a>
					</li>
					@endif

					<!-- <li class="nav-item {{($submenu_active == 'transaction-autoresponse-topup-success') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/topup-success')}}" class="nav-link ">
							<span class="title">[Response] Topup Success</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-admin-notification') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/admin-notification')}}" class="nav-link ">
							<span class="title">[Response] Admin Notification</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-generate-approval-code') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/generate-approval-code')}}" class="nav-link ">
							<span class="title">[Response] Generate Approval Code</span>
						</a>
					</li> -->
				</ul>
			</li>
			@endif

			@if(MyHelper::hasAccess([18], $configs))
				@if(MyHelper::hasAccess([71], $grantedFeature))
				<li class="nav-item {{($menu_active == 'point') ? 'active' : ''}}">
					<a href="{{url('transaction/point')}}" class="nav-link nav-toggle">
						<i class="fa fa-history"></i>
						<span class="title">Point Log History</span>
					</a>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([19], $configs))
				@if(MyHelper::hasAccess([71], $grantedFeature))
				<li class="nav-item {{($menu_active == 'balance') ? 'active' : ''}}">
					<a href="{{url('transaction/balance')}}" class="nav-link nav-toggle">
						<i class="fa fa-clock-o"></i>
						<span class="title">{{env('POINT_NAME', 'Points')}} Log History</span>
					</a>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([58,59,60,61,62,63], $grantedFeature))
			<li class="nav-item {{($menu_active == 'order') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="fa fa-cogs"></i>
					<span class="title">Order Settings</span>
					<span class="arrow {{($menu_active == 'order') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([58,59,60,62], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'transaction-rule') ? 'active open' : ''}}">
						<a href="{{url('transaction/setting/rule')}}" class="nav-link ">
							<span class="title">Calculation Rule</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([13], $configs))
						@if(MyHelper::hasAccess([14], $configs))
							@if(MyHelper::hasAccess([61,63], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'internal-courier') ? 'active open' : ''}}">
								<a href="{{url('transaction/internalcourier')}}" class="nav-link ">
									<span class="title">Internal Courier</span>
								</a>
							</li>
							@endif
						@endif
					@endif
					@if(MyHelper::hasAccess([12], $configs))
						@if(MyHelper::hasAccess([58], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'transaction-processing') ? 'active open' : ''}}">
							<a href="{{url('setting/processing_time')}}" class="nav-link ">
								<span class="title">Processing Time</span>
							</a>
						</li>
						@endif
					@endif
					@if(MyHelper::hasAccess([58,59,60,62], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'transaction-setting') ? 'active open' : ''}}">
						<a href="{{url('transaction/setting/cashback')}}" class="nav-link ">
							<span class="title">Global {{env('POINT_NAME', 'Points')}} Setting</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([79], $configs))
					<li class="nav-item {{($submenu_active == 'free-delivery') ? 'active open' : ''}}">
						<a href="{{url('transaction/setting/free-delivery')}}" class="nav-link ">
							<span class="title">Setting Free Delivery</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([80], $configs))
					<li class="nav-item {{($submenu_active == 'go-send-package-detail') ? 'active open' : ''}}">
						<a href="{{url('transaction/setting/go-send-package-detail')}}" class="nav-link ">
							<span class="title">Setting GO-SEND Package Detail</span>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif

			@if(MyHelper::hasAccess([62], $grantedFeature))
			<li class="nav-item {{($menu_active == 'product-price') ? 'active' : ''}}">
				<a href="{{url('product/price')}}" class="nav-link nav-toggle">
					<i class="fa fa-tag"></i>
					<span class="title">Outlet Product Price</span>
				</a>
			@endif

			@if(MyHelper::hasAccess([17], $configs))
				@if(MyHelper::hasAccess([64,66], $grantedFeature))
				<li class="nav-item {{($menu_active == 'manual-payment') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-money"></i>
						<span class="title">Manual Payment</span>
						<span class="arrow {{($menu_active == 'order') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([66], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'manual-payment-method-new') ? 'active open' : ''}}">
								<a href="{{url('transaction/manualpayment/create')}}" class="nav-link ">
									<span class="title">New Payment Method</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([64], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'manual-payment-method-list') ? 'active open' : ''}}">
								<a href="{{url('transaction/manualpayment')}}" class="nav-link ">
									<span class="title">Payment Method List</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([64], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'manual-payment-list') ? 'active open' : ''}}">
								<a href="{{url('transaction/manualpayment/list')}}" class="nav-link ">
									<span class="title">Manual Payment Transaction</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([25], $configs))
							@if(MyHelper::hasAccess([64], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'manual-payment-deals') ? 'active open' : ''}}">
									<a href="{{url('deals/manualpayment/list')}}" class="nav-link ">
										<span class="title">Manual Payment Deals</span>
									</a>
								</li>
							@endif
						@endif
						@if(MyHelper::hasAccess([25], $configs))
							@if(MyHelper::hasAccess([64], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'bank') ? 'active open' : ''}}">
									<a href="{{url('transaction/manualpayment/banks')}}" class="nav-link ">
										<span class="title">Bank List</span>
									</a>
								</li>
							@endif
						@endif
						@if(MyHelper::hasAccess([25], $configs))
							@if(MyHelper::hasAccess([64], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'bank-method') ? 'active open' : ''}}">
									<a href="{{url('transaction/manualpayment/banks/method')}}" class="nav-link ">
										<span class="title">Payment Method List</span>
									</a>
								</li>
							@endif
						@endif
					</ul>
				</li>
				@endif
			@endif
			@if(MyHelper::hasAccess([92], $configs) && MyHelper::hasAccess([197,199], $grantedFeature) )
			<li class="nav-item {{($menu_active == 'user-rating') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="fa fa-star-o"></i>
					<span class="title">User Rating</span>
					<span class="arrow {{($menu_active == 'user-rating') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([197], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'user-rating-list') ? 'active open' : ''}}">
							<a href="{{url('user-rating')}}" class="nav-link ">
								<span class="title">User Rating List</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([199], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'rating-setting') ? 'active open' : ''}}">
							<a href="{{url('user-rating/setting')}}" class="nav-link ">
								<span class="title">User Rating Setting</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([197], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'user-rating-report') ? 'active open' : ''}}">
							<a href="{{url('user-rating/report')}}" class="nav-link ">
								<span class="title">User Rating Report</span>
							</a>
						</li>
					@endif
				</ul>
			</li>
			@endif
		@endif

		@if(MyHelper::hasAccess([25], $configs) || MyHelper::hasAccess([26], $configs))
			@if(MyHelper::hasAccess([72,73,74,75,76,77,78,79,80,81,95], $grantedFeature))
				<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
					<h3 class="uppercase" style="color: #10704e;font-weight: 600;">Promo</h3>
				</li>
				@if(MyHelper::hasAccess([25], $configs))
					@if(MyHelper::hasAccess([72,73,74,75,76], $grantedFeature))
					<li class="nav-item {{($menu_active == 'deals') ? 'active open' : ''}}">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-gift"></i>
							<span class="title">Deals</span>
							<span class="arrow {{($menu_active == 'deals') ? 'open' : ''}}"></span>
						</a>
						<ul class="sub-menu">
							@if(MyHelper::hasAccess([74], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'deals-create') ? 'active open' : ''}}">
								<a href="{{url('deals/create')}}" class="nav-link ">
									<span class="title">New Deals</span>
								</a>
							</li>
							@endif
							@if(MyHelper::hasAccess([72], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'deals-list') ? 'active open' : ''}}">
								<a href="{{url('deals')}}" class="nav-link ">
									<span class="title">Deals List</span>
								</a>
							</li>
							@endif
							@if(MyHelper::hasAccess([18], $configs))
								@if(MyHelper::hasAccess([74], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'deals-point-create') ? 'active open' : ''}}">
									<a href="{{url('deals-point/create')}}" class="nav-link ">
										<span class="title">New Point Deals</span>
									</a>
								</li>
								@endif
								@if(MyHelper::hasAccess([72], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'deals-point-list') ? 'active open' : ''}}">
									<a href="{{url('deals-point')}}" class="nav-link ">
										<span class="title">Deals Point List</span>
									</a>
								</li>
								@endif
							@endif
						</ul>
					</li>
					@endif
				@endif


				<!-- @if(MyHelper::hasAccess([139,140,141,142,143], $grantedFeature))
					<li class="nav-item {{($menu_active == 'deals-subscription') ? 'active open' : ''}}">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-present"></i>
							<span class="title">Deals Subscription</span>
							<span class="arrow {{($menu_active == 'deals-subscription') ? 'open' : ''}}"></span>
						</a>
						<ul class="sub-menu">
							@if(MyHelper::hasAccess([141], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'deals-subscription-create') ? 'active open' : ''}}">
								<a href="{{url('deals-subscription/create')}}" class="nav-link ">
									<span class="title">New Deals Subscription</span>
								</a>
							</li>
							@endif
							@if(MyHelper::hasAccess([139,140,142,143], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'deals-subscription-list') ? 'active open' : ''}}">
								<a href="{{url('deals-subscription')}}" class="nav-link ">
									<span class="title">Deals Subscription List</span>
								</a>
							</li>
							@endif
						</ul>
					</li>
				@endif -->


				@if(MyHelper::hasAccess([26], $configs))
					@if(MyHelper::hasAccess([77,78,79,80,81], $grantedFeature))
					<li class="nav-item {{($menu_active == 'inject-voucher') ? 'active open' : ''}}">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-birthday-cake"></i>
							<span class="title">Inject Voucher</span>
							<span class="arrow {{($menu_active == 'inject-voucher') ? 'open' : ''}}"></span>
						</a>
						<ul class="sub-menu">
							@if(MyHelper::hasAccess([79], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'inject-voucher-create') ? 'active open' : ''}}">
								<a href="{{url('inject-voucher/create')}}" class="nav-link ">
									<span class="title">New Inject Voucher</span>
								</a>
							</li>
							@endif
							@if(MyHelper::hasAccess([77], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'inject-voucher-list') ? 'active open' : ''}}">
								<a href="{{url('inject-voucher')}}" class="nav-link ">
									<span class="title">Inject Voucher List</span>
								</a>
							</li>
							@endif
						</ul>
					</li>
					@endif
				@endif

				@if(MyHelper::hasAccess([179,180,181,182,183], $grantedFeature))
					<li class="nav-item {{($menu_active == 'welcome-voucher') ? 'active open' : ''}}">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-ticket"></i>
							<span class="title">Welcome Voucher</span>
							<span class="arrow {{($menu_active == 'welcome-voucher') ? 'open' : ''}}"></span>
						</a>
						<ul class="sub-menu">
							@if(MyHelper::hasAccess([181], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'welcome-voucher-create') ? 'active open' : ''}}">
									<a href="{{url('welcome-voucher/create')}}" class="nav-link ">
										<span class="title">New Welcome Voucher</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([179], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'welcome-voucher-list') ? 'active open' : ''}}">
									<a href="{{url('welcome-voucher')}}" class="nav-link ">
										<span class="title">Welcome Voucher List</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([179,182], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'welcome-voucher-setting') ? 'active open' : ''}}">
									<a href="{{url('welcome-voucher/setting')}}" class="nav-link ">
										<span class="title">Welcome Voucher Setting</span>
									</a>
								</li>
							@endif
							<li class="nav-item {{($submenu_active == 'deals-autoresponse-welcome-voucher') ? 'active open' : ''}}">
								<a href="{{url('transaction/autoresponse/receive-welcome-voucher')}}" class="nav-link ">
									<span class="title">[Response] Welcome Voucher</span>
								</a>
							</li>
						</ul>
					</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([72], $grantedFeature))
			<li class="nav-item {{($menu_active == 'deals-transaction') ? 'active open' : ''}}">
				<a href="{{url('deals/transaction')}}" class="nav-link nav-toggle">
					<i class="fa fa-bar-chart"></i>
					<span class="title">Deals Transaction</span>
				</a>
			</li>
			@endif

			@if(MyHelper::hasAccess([95], $configs))
				@if(MyHelper::hasAccess([221,222,223,224,225], $grantedFeature))
				<li class="nav-item {{($menu_active == 'promo-campaign') ? 'active open' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-tag"></i>
						<span class="title">Promo Campaign</span>
						<span class="arrow {{($menu_active == 'promo-campaign') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([223], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'promo-campaign-create') ? 'active open' : ''}}">
							<a href="{{url('promo-campaign/create')}}" class="nav-link ">
								<span class="title">New Promo Campaign</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([221], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'promo-campaign-list') ? 'active open' : ''}}">
							<a href="{{url('promo-campaign')}}" class="nav-link ">
								<span class="title">Promo Campaign List</span>
							</a>
						</li>
						@endif
					</ul>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([234], $grantedFeature))
			<li class="nav-item {{($menu_active == 'warning-image') ? 'active open' : ''}}">
				<a href="{{url('promo-setting/warning-image')}}" class="nav-link nav-toggle">
					<i class="fa fa-picture-o"></i>
					<span class="title">Warning Image</span>
				</a>
			</li>
			@endif
			@if(MyHelper::hasAccess([236], $grantedFeature))
			<li class="nav-item {{($menu_active == 'promo-cashback-setting') ? 'active open' : ''}}">
				<a href="{{url('promo-setting/cashback')}}" class="nav-link nav-toggle">
					<i class="fa fa-money"></i>
					<span class="title">Promo Cashback Setting</span>
				</a>
			</li>
			@endif

			@if(MyHelper::hasAccess([95], $configs))
				@if(MyHelper::hasAccess([228], $grantedFeature))
				<li class="nav-item {{($menu_active == 'referral') ? 'active open' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-user-plus"></i>
						<span class="title">Referral</span>
						<span class="arrow {{($menu_active == 'referral') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([228], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'referral-setting') ? 'active open' : ''}}">
							<a href="{{url('referral/setting')}}" class="nav-link ">
								<span class="title">Referral Setting</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([216], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'referral-report') ? 'active open' : ''}}">
							<a href="{{url('referral/report')}}" class="nav-link ">
								<span class="title">Referral Report</span>
							</a>
						</li>
						@endif
					</ul>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([49], $configs))
				@if(MyHelper::hasAccess([95], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'deals-autoresponse-claim-free-deals-success') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/claim-free-deals-success')}}" class="nav-link ">
							<i class="fa fa-mail-forward"></i>
							<span class="title">[Response] Claim Free Deals Success</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'deals-autoresponse-claim-paid-deals-success') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/claim-paid-deals-success')}}" class="nav-link ">
							<i class="fa fa-mail-forward"></i>
							<span class="title">[Response] Claim Paid Deals Success</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'deals-autoresponse-redeem-deals-success') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/redeem-voucher-success')}}" class="nav-link ">
							<i class="fa fa-mail-forward"></i>
							<span class="title">[Response] Redeems Deals</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'deals-autoresponse-receive-inject-voucher') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/receive-inject-voucher')}}" class="nav-link ">
							<i class="fa fa-mail-forward"></i>
							<span class="title">[Response] Receive Inject Voucher</span>
						</a>
					</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([73], $configs))
				@if(MyHelper::hasAccess([130,131,132,133,134], $grantedFeature))
				<li class="nav-item {{($menu_active == 'reward') ? 'active open' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-trophy"></i>
						<span class="title">Reward</span>
						<span class="arrow {{($menu_active == 'reward') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([132], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'reward-create') ? 'active open' : ''}}">
							<a href="{{url('reward/create')}}" class="nav-link ">
								<span class="title">New Reward</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([130,131,133,134], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'reward-list') ? 'active open' : ''}}">
							<a href="{{url('reward')}}" class="nav-link ">
								<span class="title">Reward List</span>
							</a>
						</li>
						@endif
					</ul>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([76], $configs))
				@if(MyHelper::hasAccess([130,131,134], $grantedFeature))
				<li class="nav-item {{($menu_active == 'spinthewheel') ? 'active open' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-circle-o-notch"></i>
						<span class="title">Spin The Wheel</span>
						<span class="arrow {{($menu_active == 'spinthewheel') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([131], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'spinthewheel-new') ? 'active open' : ''}}">
							<a href="{{url('spinthewheel/create')}}" class="nav-link ">
								<span class="title">New Item</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([130], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'spinthewheel-list') ? 'active open' : ''}}">
							<a href="{{url('spinthewheel/list')}}" class="nav-link ">
								<span class="title">Item List</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([134], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'spinthewheel-setting') ? 'active open' : ''}}">
							<a href="{{url('spinthewheel/setting')}}" class="nav-link ">
								<span class="title">Setting</span>
							</a>
						</li>
						@endif
					</ul>
				</li>
				@endif
			@endif
		@endif

		@if(MyHelper::hasAccess([83,96,97,98,100,103,104,105,106,107,108,109,111], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #10704e;font-weight: 600;">CRM</h3>
			</li>

			@if(MyHelper::hasAccess([96,97], $grantedFeature))
			<li class="nav-item {{($menu_active == 'crm-setting') ? 'active' : ''}}">
				<a href="{{url('autocrm')}}" class="nav-link nav-toggle">
					<i class="icon-settings"></i>
					<span class="title">CRM Setting</span>
					<span class="arrow {{($menu_active == 'crm-setting') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([96], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'textreplace') ? 'active' : ''}}">
						<a href="{{url('textreplace')}}" class="nav-link nav-toggle">
							<span class="title">Text Replace</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([97], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'email') ? 'active' : ''}}">
						<a href="{{url('email-header-footer')}}" class="nav-link nav-toggle">
							<span class="title">Email Header & Footer</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([74,75], $configs))
					<li class="nav-item {{($submenu_active == 'whatsapp') ? 'active' : ''}}">
						<a href="{{url('setting/whatsapp')}}" class="nav-link nav-toggle">
							<span class="title">WhatsApp Setting</span>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif
			@if(MyHelper::hasAccess([58], $configs) || MyHelper::hasAccess([59], $configs) || MyHelper::hasAccess([60], $configs))
				@if(MyHelper::hasAccess([83], $grantedFeature))
				<li class="nav-item {{($menu_active == 'enquiries') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-action-undo"></i>
						<span class="title">Enquiries</span>
						<span class="arrow {{($menu_active == 'enquiries') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item {{($submenu_active == 'enquiries-list') ? 'active open' : ''}}">
							<a href="{{url('enquiries')}}" class="nav-link">
								<span class="title">Enquiry List</span>
							</a>
						</li>
						@if(MyHelper::hasAccess([40], $configs))
							@if(MyHelper::hasAccess([94], $grantedFeature))
								@if(MyHelper::hasAccess([46], $configs))
								<li class="nav-item {{($submenu_active == 'autoresponse-enquiry-customer-feedback') ? 'active open' : ''}}">
									<a href="{{url('about/autoresponse/enquiry-customer-feedback')}}" class="nav-link ">
										<span class="title">[Response] Enquiry Customer Feedback</span>
									</a>
								</li>
								@endif
								@if(MyHelper::hasAccess([47], $configs))
									<li class="nav-item {{($submenu_active == 'autoresponse-enquiry-marketing-partnership') ? 'active open' : ''}}">
										<a href="{{url('about/autoresponse/enquiry-marketing-partnership')}}" class="nav-link ">
											<span class="title">[Response] Enquiry Marketing Partnership</span>
										</a>
									</li>
								@endif
								@if(MyHelper::hasAccess([48], $configs))
									<li class="nav-item {{($submenu_active == 'autoresponse-enquiry-business-development') ? 'active open' : ''}}">
										<a href="{{url('about/autoresponse/enquiry-business-development')}}" class="nav-link ">
											<span class="title">[Response] Enquiry Business Development</span>
										</a>
									</li>
								@endif
								@if(MyHelper::hasAccess([47], $configs))
									<li class="nav-item {{($submenu_active == 'autoresponse-enquiry-career') ? 'active open' : ''}}">
										<a href="{{url('about/autoresponse/enquiry-career')}}" class="nav-link ">
											<span class="title">[Response] Enquiry Career</span>
										</a>
									</li>
								@endif
							@endif
						@endif
					</ul>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([50], $configs))
				@if(MyHelper::hasAccess([98,100,103,104,105,106,107,108], $grantedFeature))
				<li class="nav-item {{($menu_active == 'campaign') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-speech"></i>
						<span class="title"> Single Campaign</span>
						<span class="arrow {{($menu_active == 'campaign') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([100], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'campaign-create') ? 'active open' : ''}}">
							<a href="{{url('campaign/create')}}" class="nav-link ">
								<span class="title">New Campaign</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([98], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'campaign-list') ? 'active open' : ''}}">
								<a href="{{url('campaign')}}" class="nav-link ">
									<span class="title">Campaign List</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([51], $configs))
							@if(MyHelper::hasAccess([104], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'campaign-email-outbox') ? 'active open' : ''}}">
									<a href="{{url('campaign/email/outbox')}}" class="nav-link ">
										<span class="title">Email Outbox</span>
									</a>
								</li>
							@endif
						@endif
						@if(MyHelper::hasAccess([52], $configs))
							@if(MyHelper::hasAccess([106], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'campaign-sms-outbox') ? 'active open' : ''}}">
									<a href="{{url('campaign/sms/outbox')}}" class="nav-link ">
										<span class="title">SMS Outbox</span>
									</a>
								</li>
							@endif
						@endif
						@if(MyHelper::hasAccess([53], $configs))
							@if(MyHelper::hasAccess([108], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'campaign-push-outbox') ? 'active open' : ''}}">
									<a href="{{url('campaign/push/outbox')}}" class="nav-link ">
										<span class="title">Push Outbox</span>
									</a>
								</li>
							@endif
						@endif
						@if(MyHelper::hasAccess([75], $configs))
							@if(MyHelper::hasAccess([108], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'campaign-whatsapp-outbox') ? 'active open' : ''}}">
									<a href="{{url('campaign/whatsapp/outbox')}}" class="nav-link ">
										<span class="title">WhatsApp Outbox</span>
									</a>
								</li>
							@endif
						@endif
					</ul>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([72], $configs))
				@if(MyHelper::hasAccess([109,110,111,112,113], $grantedFeature))
				<li class="nav-item {{($menu_active == 'promotion') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-emoticon-smile"></i>
						<span class="title">Promotion</span>
						<span class="arrow {{($menu_active == 'promotion') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item {{($submenu_active == 'new-deals-promotion') ? 'active open' : ''}}">
							<a href="{{url('promotion/deals/create')}}" class="nav-link ">
								<span class="title">New Deals Promotion</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'deals-promotion') ? 'active open' : ''}}">
							<a href="{{url('promotion/deals')}}" class="nav-link ">
								<span class="title">Deals Promotion</span>
							</a>
						</li>
						@if(MyHelper::hasAccess([111], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'promotion-create') ? 'active open' : ''}}">
							<a href="{{url('promotion/create')}}" class="nav-link ">
								<span class="title">New Promotion</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([109], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'promotion-list') ? 'active open' : ''}}">
								<a href="{{url('promotion')}}" class="nav-link ">
									<span class="title">Promotion List</span>
								</a>
							</li>
						@endif
					</ul>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([206,207,208,209,210], $grantedFeature))
			<li class="nav-item {{($menu_active == 'point-injection') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-diamond"></i>
					<span class="title">Point Injection</span>
					<span class="arrow {{($menu_active == 'point-injection') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					<li class="nav-item {{($submenu_active == 'point-injection-create') ? 'active open' : ''}}">
						<a href="{{url('point-injection/create')}}" class="nav-link ">
							<span class="title">New Point Injection</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'point-injection-create') ? 'active open' : ''}}">
						<a href="{{url('point-injection')}}" class="nav-link ">
							<span class="title">List Point Injection</span>
						</a>
					</li>
				</ul>
			</li>
			@endif

			@if(MyHelper::hasAccess([114,115,116,117,118], $grantedFeature))
				<li class="nav-item {{($menu_active == 'inboxglobal') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-feed"></i>
						<span class="title">Inbox Global</span>
						<span class="arrow {{($menu_active == 'inboxglobal') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([116], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'inboxglobal-create') ? 'active' : ''}}">
								<a href="{{url('inboxglobal/create')}}" class="nav-link ">
									<span class="title">New Inbox Global</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([114], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'inboxglobal-list') ? 'active' : ''}}">
								<a href="{{url('inboxglobal')}}" class="nav-link ">
									<span class="title">Inbox Global List</span>
								</a>
							</li>
						@endif
					</ul>
				</li>
			@endif

			<!-- @if(MyHelper::hasAccess([55], $configs))
				@if(MyHelper::hasAccess([119,120,121,122,123], $grantedFeature))
				<li class="nav-item {{($menu_active == 'autocrm') ? 'active' : ''}}">
					<a href="{{url('autocrm')}}" class="nav-link nav-toggle">
						<i class="icon-ghost"></i>
						<span class="title">Auto CRM</span>
						<span class="arrow {{($menu_active == 'autocrm') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([121], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'autocrm-new') ? 'active' : ''}}">
							<a href="{{url('autocrm/create')}}" class="nav-link nav-toggle">
								<span class="title">New Auto CRM</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([119], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'autocrm-list') ? 'active' : ''}}">
							<a href="{{url('autocrm')}}" class="nav-link nav-toggle">
								<span class="title">Auto CRM List</span>
							</a>
						</li>
						@endif
					</ul>
				</li>
				@endif
			@endif -->

		@endif

		@if(MyHelper::hasAccess([15,16,17,18,144,145,146,147,148], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #10704e;font-weight: 600;">Settings</h3>
			</li>
			<li class="nav-item {{($menu_active == 'setting-home') ? 'active' : ''}}">
				<a href="{{url('setting/home')}}" class="nav-link">
					<i class="icon-screen-tablet "></i>
					<span class="title">Mobile Apps Home</span>
				</a>
			</li>
		@endif

		@if(MyHelper::hasAccess([93], $configs))
		@if(MyHelper::hasAccess([211], $grantedFeature))
			<li class="nav-item {{($menu_active == 'setting-phone') ? 'active' : ''}}">
				<a href="{{url('setting/phone')}}" class="nav-link">
					<i class="fa fa-phone"></i>
					<span class="title">Setting Phone Number</span>
				</a>
			</li>
		@endif
		@endif

		@if(MyHelper::hasAccess([160], $grantedFeature))
			<li class="nav-item {{($menu_active == 'setting-text-menu') ? 'active' : ''}}">
				<a href="{{url('setting/text_menu')}}" class="nav-link">
					<i class="fa fa-bars"></i>
					<span class="title">Text Menu</span>
				</a>
			</li>
		@endif

		@if(MyHelper::hasAccess([33], $configs))
		@if (!empty($advert))
			@if(MyHelper::hasAccess([124], $grantedFeature))
			<li class="nav-item {{($menu_active == 'advert') ? 'active open' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="fa fa-newspaper-o"></i>
					<span class="title">Page Advertisement</span>
					<span class="arrow {{($menu_active == 'advert') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@foreach ($advert as $val)
					<li class="nav-item {{($submenu_active == $val ) ? 'active open' : ''}}">
						<a href="{{url('advert')}}/{{ $val }}" class="nav-link ">
							<span class="title">{{ ucwords(str_replace('-', ' ', $val)) }}</span>
						</a>
					</li>
					@endforeach
				</ul>
			</li>
			@endif
		@endif
		@endif

		@if(MyHelper::hasAccess([192,193,194,195,196,229,230,231,232,233], $grantedFeature))
			<li class="nav-item {{($menu_active == 'fraud-detection') ? 'active open' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="fa fa-exclamation"></i>
					<span class="title">Fraud Detection</span>
					<span class="arrow {{($menu_active == 'fraud-detection') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([192], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'fraud-detection-update') ? 'active open' : ''}}">
							<a href="{{url('setting-fraud-detection')}}" class="nav-link ">
								<span class="title">Fraud Detection Settings</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([193], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'report-fraud-device') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/report/device')}}" class="nav-link ">
								<span class="title">Report Fraud Device</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([229], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'report-fraud-transaction-point') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/report/transaction-point')}}" class="nav-link ">
								<span class="title">Report Fraud Transaction Point</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([194], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'report-fraud-transaction-day') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/report/transaction-day')}}" class="nav-link ">
								<span class="title">Report Fraud Transaction Day</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([195], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'report-fraud-transaction-week') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/report/transaction-week')}}" class="nav-link ">
								<span class="title">Report Fraud Transaction Week</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([230], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'report-fraud-transaction-between') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/report/transaction-between')}}" class="nav-link ">
								<span class="title">Report Fraud Transaction in Between</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([231], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'report-fraud-referral-user') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/report/referral-user')}}" class="nav-link ">
								<span class="title">Report Fraud Referral User</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([232], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'report-fraud-referral') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/report/referral')}}" class="nav-link ">
								<span class="title">Report Fraud Referral</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([233], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'report-fraud-promo-code') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/report/promo-code')}}" class="nav-link ">
								<span class="title">Report Fraud Promo Code</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([196], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'suspend-user') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/suspend-user')}}" class="nav-link ">
								<span class="title">List User Fraud</span>
							</a>
						</li>
					@endif
				</ul>
			</li>
		@endif

		@if($level == "Super Admin")
		<li class="nav-item {{($menu_active == 'setting-version') ? 'active' : ''}}">
			<a href="{{url('version')}}" class="nav-link">
				<i class="fa fa-info-circle"></i>
				<span class="title">Version Control</span>
			</a>
		</li>
		@endif

		@if(MyHelper::hasAccess([149,150,151,152,153], $grantedFeature))
		<li class="nav-item {{($menu_active == 'custom-page') ? 'active open' : ''}}">
			<a href="javascript:;" class="nav-link nav-toggle">
				<i class="icon-book-open"></i>
				<span class="title">Custom Page</span>
				<span class="arrow {{($menu_active == 'custom-page') ? 'open' : ''}}"></span>
			</a>
			<ul class="sub-menu">
				@if(MyHelper::hasAccess([150], $grantedFeature))
				<li class="nav-item {{($submenu_active == 'custom-page-create') ? 'active open' : ''}}">
					<a href="{{url('custom-page/create')}}" class="nav-link ">
						<span class="title">New Custom Page</span>
					</a>
				</li>
				@endif
				@if(MyHelper::hasAccess([149,151,152,153], $grantedFeature))
				<li class="nav-item {{($submenu_active == 'custom-page-list') ? 'active open' : ''}}">
					<a href="{{url('custom-page')}}" class="nav-link ">
						<span class="title">Custom Page List</span>
					</a>
				</li>
				@endif
			</ul>
		</li>
		@endif
		@if(MyHelper::hasAccess([168,169,170,171], $grantedFeature))
		<li class="nav-item {{($menu_active == 'setting-intro') ? 'active open' : ''}}">
			<a href="javascript:;" class="nav-link nav-toggle">
				<i class="icon-screen-tablet"></i>
				<span class="title">Intro Apps</span>
				<span class="arrow {{($menu_active == 'setting-intro') ? 'open' : ''}}"></span>
			</a>
			<ul class="sub-menu">
				@if(MyHelper::hasAccess([150], $grantedFeature))
				<li class="nav-item {{($submenu_active == 'setting-intro-first') ? 'active open' : ''}}">
					<a href="{{url('setting/intro/first')}}" class="nav-link ">
						<span class="title">Intro First Install</span>
					</a>
				</li>
				@endif
				@if(MyHelper::hasAccess([149,151,152,153], $grantedFeature))
				<li class="nav-item {{($submenu_active == 'setting-intro-home') ? 'active open' : ''}}">
					<a href="{{url('setting/intro/home')}}" class="nav-link ">
						<span class="title">Tutorial In Home</span>
					</a>
				</li>
				@endif
			</ul>
		</li>
		@endif

		@if(MyHelper::hasAccess([162,163], $grantedFeature))
		<li class="nav-item {{($menu_active == 'confirmation-messages') ? 'active' : ''}}">
			<a href="{{url('setting/confirmation-messages')}}" class="nav-link">
				<i class="icon-speech"></i>
				<span class="title">Confirmation Messages</span>
			</a>
		</li>
		@endif
		@if(MyHelper::hasAccess([235], $grantedFeature))
			<li class="nav-item {{($menu_active == 'maintenance-mode') ? 'active' : ''}}">
				<a href="{{url('setting/maintenance-mode')}}" class="nav-link">
					<i class="icon-wrench"></i>
					<span class="title">Maintenance Mode</span>
				</a>
			</li>
		@endif

		@if(MyHelper::hasAccess([85,86,87,88,89,90,91,94], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #10704e;font-weight: 600;">About</h3>
			</li>

			@if(MyHelper::hasAccess([85], $grantedFeature))
			<li class="nav-item {{($menu_active == 'about') ? 'active' : ''}}">
				<a href="{{url('setting/about')}}" class="nav-link nav-toggle">
					<i class="icon-info"></i>
					<span class="title">About</span>
				</a>
			</li>
			@endif

			@if(MyHelper::hasAccess([88,89], $grantedFeature))
			<li class="nav-item {{($menu_active == 'faq') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-question"></i>
					<span class="title">FAQ</span>
					<span class="arrow {{($menu_active == 'faq') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([89], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'faq-new') ? 'active open' : ''}}">
						<a href="{{url('setting/faq/create')}}" class="nav-link ">
							<span class="title">New FAQ</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([88], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'faq-list') ? 'active open' : ''}}">
						<a href="{{url('setting/faq')}}" class="nav-link ">
							<span class="title">List FAQ</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([88], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'faq-sort') ? 'active open' : ''}}">
							<a href="{{url('setting/faq/sort')}}" class="nav-link ">
								<span class="title">Sorting FAQ List</span>
							</a>
						</li>
					@endif
				</ul>
			</li>
			@endif
			@if(MyHelper::hasAccess([86], $grantedFeature))
			<li class="nav-item {{($menu_active == 'tos') ? 'active' : ''}}">
				<a href="{{url('setting/tos')}}" class="nav-link nav-toggle">
					<i class="icon-note"></i>
					<span class="title">Ketentuan Layanan</span>
				</a>
			</li>
			@endif
			@if(MyHelper::hasAccess([98], $configs))
			@if(MyHelper::hasAccess([154], $grantedFeature))
			<li class="nav-item {{($menu_active == 'delivery-service') ? 'active' : ''}}">
				<a href="{{url('delivery-service')}}" class="nav-link nav-toggle">
					<i class="icon-social-dropbox"></i>
					<span class="title">Delivery Services</span>
				</a>
			</li>
			@endif
			@endif
			<!-- @if(MyHelper::hasAccess([87], $grantedFeature))
			<li class="nav-item {{($menu_active == 'contact') ? 'active' : ''}}">
				<a href="{{url('setting/contact')}}" class="nav-link nav-toggle">
					<i class="icon-call-in"></i>
					<span class="title">Contact Us</span>
				</a>
			</li>
			@endif -->
		@endif

		@if(MyHelper::hasAccess([125,126,127,128,129], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #10704e;font-weight: 600;">Report</h3>
			</li>
			<li class="nav-item {{($menu_active == 'report-single') ? 'active' : ''}}">
				<a href="{{url('report')}}" class="nav-link nav-toggle">
					<i class="icon-graph"></i>
					<span class="title">Report</span>
				</a>
			</li>
			<li class="nav-item {{($menu_active == 'report-compare') ? 'active' : ''}}">
				<a href="{{url('report/compare')}}" class="nav-link nav-toggle">
					<i class="icon-graph"></i>
					<span class="title">Compare Report</span>
				</a>
			</li>
			@if(MyHelper::hasAccess([125], $grantedFeature))
			<li class="nav-item {{($menu_active == 'report-global') ? 'active' : ''}}">
				<a href="{{url('report/global')}}" class="nav-link nav-toggle">
					<i class="icon-graph"></i>
					<span class="title">Global</span>
				</a>
			</li>
			@endif
			@if(MyHelper::hasAccess([126], $grantedFeature))
			<li class="nav-item {{($menu_active == 'report-customer') ? 'active' : ''}}">
				<a href="{{url('report/customer/summary')}}" class="nav-link nav-toggle">
					<i class="icon-graph"></i>
					<span class="title">Customer</span>
				</a>
			</li>
			@endif
			@if(MyHelper::hasAccess([127], $grantedFeature))
			<li class="nav-item {{($menu_active == 'report-product') ? 'active' : ''}}">
				<a href="{{url('report/product')}}" class="nav-link nav-toggle">
					<i class="icon-graph"></i>
					<span class="title">Product</span>
				</a>
			</li>
			@endif
			@if(MyHelper::hasAccess([128], $grantedFeature))
			<li class="nav-item {{($submenu_active == 'report-outlet') ? 'active' : ''}}">
				<a href="{{url('report/outlet')}}" class="nav-link nav-toggle">
					<i class="icon-graph"></i>
					<span class="title">Outlet</span>
				</a>
			</li>
			@endif
		@endif

		@if(MyHelper::hasAccess([129], $grantedFeature))
		<li class="nav-item {{($menu_active == 'report-magic') ? 'active' : ''}}">
			<a href="{{url('report/magic')}}" class="nav-link nav-toggle">
				<i class="icon-graph"></i>
				<span class="title">Magic Report</span>
			</a>
		</li>
		@endif

	</ul>
	<!-- END SIDEBAR MENU -->
	<!-- END SIDEBAR MENU -->
<!-- END SIDEBAR -->
