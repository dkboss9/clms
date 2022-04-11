		<!--begin::Content-->
        <div class="content fs-6 d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Toolbar-->
						<div class="toolbar" id="kt_toolbar">
							<div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
									<!--begin::Title-->
									<h1 class="text-dark fw-bolder my-1 fs-2">View Contact</h1>
									<!--end::Title-->
									<!--begin::Breadcrumb-->
									<ul class="breadcrumb fw-bold fs-base my-1">
										<li class="breadcrumb-item text-muted">
											<a href="../dist/index.html" class="text-muted text-hover-primary">Home</a>
										</li>
										<li class="breadcrumb-item text-muted">Contacts</li>
										<li class="breadcrumb-item text-dark">View Contact</li>
									</ul>
									<!--end::Breadcrumb-->
								</div>
								<!--end::Info-->
								<!--begin::Actions-->
								<div class="d-flex align-items-center flex-nowrap text-nowrap py-1">
									<a href="<?php echo base_url("student/list");?>" class="btn bg-body btn-color-gray-700 btn-active-primary me-4" >List View</a>
									<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button">New Customer</a>
								</div>
								<!--end::Actions-->
							</div>
						</div>
						<!--end::Toolbar-->
						<!--begin::Post-->
						<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
							<!--begin::Container-->
							<div class="container-xxl">
								<!--begin::Contacts App- View Contact-->
								<div class="row g-7">
									<!--begin::Contact groups-->
									<div class="col-lg-6 col-xl-3">
										<!--begin::Contact group wrapper-->
										<div class="card card-flush">
											<!--begin::Card header-->
											<div class="card-header pt-7" id="kt_chat_contacts_header">
												<!--begin::Card title-->
												<div class="card-title">
													<h2>Campaign on contact </h2>
												</div>
												<!--end::Card title-->
											</div>
											<!--end::Card header-->
											<!--begin::Card body-->
											<div class="card-body pt-5">
												<!--begin::Contact groups-->
												<div class="d-flex flex-column gap-5">
													<!--begin::Contact group-->
													<div class="d-flex flex-stack">
														<a href="#" class="fs-6 fw-bolder text-gray-800 text-hover-primary text-active-primary active">All Contacts</a>
														<div class="badge badge-light-primary"><?php echo $total_contacts;?></div>
													</div>
													<!--begin::Contact group-->
													<?php foreach($campaigns as $campaign){?>
													<!--begin::Contact group-->
													<div class="d-flex flex-stack">
														<a href="<?php echo base_url();?>" class="fs-6 fw-bolder text-gray-800 text-hover-primary"><?php echo $campaign->campaign_name;?></a>
														<div class="badge badge-light-primary">3</div>
													</div>
													<!--begin::Contact group-->
													<?php } ?>
												
												</div>
												<!--end::Contact groups-->
												<!--begin::Separator-->
												<div class="separator my-7"></div>
												<!--begin::Separator-->
												<!--begin::Add contact group-->
												<label class="fs-6 fw-bold form-label">Add new campaign</label>
												<div class="input-group">
													<input type="text" class="form-control form-control-solid" placeholder="Campaign name" />
													<button type="button" class="btn btn-icon btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_add_campaigns">
														<!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
														<span class="svg-icon svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="black" />
																<rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="black" />
																<rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
													</button>
												</div>
												<!--end::Add contact group-->
												<!--begin::Separator-->
												<div class="separator my-7"></div>
												<!--begin::Separator-->
												<!--begin::Add new contact-->
												<a href="javascript:void();" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#kt_modal_add_contacts" id="kt_toolbar_primary_button">
												<!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
												<span class="svg-icon svg-icon-2">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="black" />
														<path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon-->Add new contact</a>
												<!--end::Add new contact-->
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Contact group wrapper-->
									</div>
									<!--end::Contact groups-->
									<!--begin::Search-->
									<div class="col-lg-6 col-xl-3">
										<!--begin::Contacts-->
										<div class="card card-flush" id="kt_contacts_list">
											<!--begin::Card header-->
											<div class="card-header pt-7" id="kt_contacts_list_header">
												<!--begin::Form-->
												<form class="d-flex align-items-center position-relative w-100 m-0" autocomplete="off">
													<!--begin::Icon-->
													<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
													<span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
															<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
														</svg>
													</span>
													<!--end::Svg Icon-->
													<!--end::Icon-->
													<!--begin::Input-->
													<input type="text" class="form-control form-control-solid ps-13" name="search" value="" placeholder="Search contacts" />
													<!--end::Input-->
												</form>
												<!--end::Form-->
											</div>
											<!--end::Card header-->
											<!--begin::Card body-->
											<div class="card-body pt-5" id="kt_contacts_list_body">
												<!--begin::List-->
												<div class="scroll-y me-n5 pe-5 h-300px h-xl-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_contacts_list_header" data-kt-scroll-wrappers="#kt_content, #kt_contacts_list_body" data-kt-scroll-stretch="#kt_contacts_list, #kt_contacts_main" data-kt-scroll-offset="5px">
												<?php foreach($student->result() as $row){?>
												<!--begin::User-->
													<div class="d-flex flex-stack py-4">
														<!--begin::Details-->
														<div class="d-flex align-items-center">
															<!--begin::Avatar-->
															<div class="symbol symbol-40px symbol-circle">
																<?php if($row->picture && file_exists("../uploads/document/".$row->picture)){ ?>
																<img alt="Pic" src="<?php echo SITE_URL;?>uploads/document/<?php echo $row->picture;?>" />
																	<?php }else{ ?>
																<span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder"><?php echo substr($row->first_name,0,1);?> <?php echo substr($row->last_name,0,1);?></span>
															<?php } ?>
															</div>
															<!--end::Avatar-->
															<!--begin::Details-->
															<div class="ms-4">
																<a href="<?php echo base_url("student/listall?studentid=".$row->uuid)?>" class="fs-6 fw-bolder text-gray-900 text-hover-primary mb-2"><?php echo $row->first_name;?> <?php echo $row->last_name;?></a>
																<div class="fw-bold fs-7 text-muted"><?php echo $row->email;?></div>
															</div>
															<!--end::Details-->
														</div>
														<!--end::Details-->
													</div>
													<!--end::User-->
													<!--begin::Separator-->
													<div class="separator separator-dashed d-none"></div>
													<!--end::Separator-->
													<?php } ?>
													
												
												</div>
												<!--end::List-->
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Contacts-->
									</div>
									<!--end::Search-->
									<!--begin::Content-->
									<div class="col-xl-6">
										<!--begin::Contacts-->
										<div class="card card-flush h-lg-100" id="kt_contacts_main">
											<!--begin::Card header-->
											<div class="card-header pt-7" id="kt_chat_contacts_header">
												<!--begin::Card title-->
												<div class="card-title">
													<!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
													<span class="svg-icon svg-icon-1 me-2">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="black" />
															<path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="black" />
														</svg>
													</span>
													<!--end::Svg Icon-->
													<h2>Contact Details</h2>
												</div>
												<!--end::Card title-->
												<!--begin::Card toolbar-->
												<div class="card-toolbar gap-3">
													<!--begin::Chat-->
													<button class="btn btn-sm btn-light btn-active-light-primary" data-kt-drawer-show="true" data-kt-drawer-target="#kt_drawer_chat">
													<!--begin::Svg Icon | path: icons/duotune/communication/com012.svg-->
													<span class="svg-icon svg-icon-2">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path opacity="0.3" d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z" fill="black" />
															<rect x="6" y="12" width="7" height="2" rx="1" fill="black" />
															<rect x="6" y="7" width="12" height="2" rx="1" fill="black" />
														</svg>
													</span>
													<!--end::Svg Icon-->Chat</button>
													<!--end::Chat-->
													<!--begin::Chat-->
													<a href="../dist/apps/inbox/reply.html" class="btn btn-sm btn-light btn-active-light-primary">
													<!--begin::Svg Icon | path: icons/duotune/communication/com007.svg-->
													<span class="svg-icon svg-icon-2">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path opacity="0.3" d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z" fill="black" />
															<path d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z" fill="black" />
														</svg>
													</span>
													<!--end::Svg Icon-->Message</a>
													<!--end::Chat-->
													<!--begin::Action menu-->
													<a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
														<!--begin::Svg Icon | path: icons/duotune/general/gen052.svg-->
														<span class="svg-icon svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<rect x="10" y="10" width="4" height="4" rx="2" fill="black" />
																<rect x="17" y="10" width="4" height="4" rx="2" fill="black" />
																<rect x="3" y="10" width="4" height="4" rx="2" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
													</a>
													<!--begin::Menu-->
													<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
														<!--begin::Menu item-->
														<div class="menu-item px-3">
															<a href="javascript:void();" class="menu-link px-3 link_edit" studentid="<?php echo $detail->id;?>" data-bs-toggle="modal"
													data-bs-target="#kt_modal_create_project">Edit</a>
														</div>
														<!--end::Menu item-->
														<!--begin::Menu item-->
														<div class="menu-item px-3">
															<a href="#" class="menu-link px-3" id="kt_contact_delete" data-kt-redirect="../dist/apps/contacts/getting-started.html">Delete</a>
														</div>
														<!--end::Menu item-->
													</div>
													<!--end::Menu-->
													<!--end::Action menu-->
												</div>
												<!--end::Card toolbar-->
											</div>
											<!--end::Card header-->
											<!--begin::Card body-->
											<div class="card-body pt-5">
												<!--begin::Profile-->
												<div class="d-flex gap-7 align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-circle symbol-100px">
														<img src="<?php echo base_url("assets/theme/dist/");?>assets/media/avatars/300-6.jpg" alt="image" />
													</div>
													<!--end::Avatar-->
													<!--begin::Contact details-->
													<div class="d-flex flex-column gap-2">
														<!--begin::Name-->
														<h3 class="mb-0">Emma Smith</h3>
														<!--end::Name-->
														<!--begin::Email-->
														<div class="d-flex align-items-center gap-2">
															<!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
															<span class="svg-icon svg-icon-2">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="black" />
																	<path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="black" />
																</svg>
															</span>
															<!--end::Svg Icon-->
															<a href="#" class="text-muted text-hover-primary">smith@kpmg.com</a>
														</div>
														<!--end::Email-->
														<!--begin::Phone-->
														<div class="d-flex align-items-center gap-2">
															<!--begin::Svg Icon | path: icons/duotune/electronics/elc003.svg-->
															<span class="svg-icon svg-icon-2">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<path d="M5 20H19V21C19 21.6 18.6 22 18 22H6C5.4 22 5 21.6 5 21V20ZM19 3C19 2.4 18.6 2 18 2H6C5.4 2 5 2.4 5 3V4H19V3Z" fill="black" />
																	<path opacity="0.3" d="M19 4H5V20H19V4Z" fill="black" />
																</svg>
															</span>
															<!--end::Svg Icon-->
															<a href="#" class="text-muted text-hover-primary">+6141 234 567</a>
														</div>
														<!--end::Phone-->
													</div>
													<!--end::Contact details-->
												</div>
												<!--end::Profile-->
												<!--begin:::Tabs-->
												<ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x fs-6 fw-bold mt-6 mb-8">
													<!--begin:::Tab item-->
													<li class="nav-item">
														<a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_contact_view_general">
														<!--begin::Svg Icon | path: icons/duotune/general/gen001.svg-->
														<span class="svg-icon svg-icon-4 me-1">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M11 2.375L2 9.575V20.575C2 21.175 2.4 21.575 3 21.575H9C9.6 21.575 10 21.175 10 20.575V14.575C10 13.975 10.4 13.575 11 13.575H13C13.6 13.575 14 13.975 14 14.575V20.575C14 21.175 14.4 21.575 15 21.575H21C21.6 21.575 22 21.175 22 20.575V9.575L13 2.375C12.4 1.875 11.6 1.875 11 2.375Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->General</a>
													</li>
													<!--end:::Tab item-->
													<!--begin:::Tab item-->
													<li class="nav-item">
														<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_contact_view_meetings">
														<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
														<span class="svg-icon svg-icon-4 me-1">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="black" />
																<path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="black" />
																<path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->Meetings</a>
													</li>
													<!--end:::Tab item-->
													<!--begin:::Tab item-->
													<li class="nav-item">
														<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_contact_view_activity">
														<!--begin::Svg Icon | path: icons/duotune/general/gen056.svg-->
														<span class="svg-icon svg-icon-4 me-1">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M16.0077 19.2901L12.9293 17.5311C12.3487 17.1993 11.6407 17.1796 11.0426 17.4787L6.89443 19.5528C5.56462 20.2177 4 19.2507 4 17.7639V5C4 3.89543 4.89543 3 6 3H17C18.1046 3 19 3.89543 19 5V17.5536C19 19.0893 17.341 20.052 16.0077 19.2901Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->Activity</a>
													</li>
													<!--end:::Tab item-->
												</ul>
												<!--end:::Tabs-->
												<!--begin::Tab content-->
												<div class="tab-content" id="">
													<!--begin:::Tab pane-->
													<div class="tab-pane fade show active" id="kt_contact_view_general" role="tabpanel">
														<!--begin::Additional details-->
														<div class="d-flex flex-column gap-5 mt-7">
															<!--begin::Company name-->
															<div class="d-flex flex-column gap-1">
																<div class="fw-bolder text-muted">Company Name</div>
																<div class="fw-bolder fs-5">Keenthemes Inc</div>
															</div>
															<!--end::Company name-->
															<!--begin::City-->
															<div class="d-flex flex-column gap-1">
																<div class="fw-bolder text-muted">City</div>
																<div class="fw-bolder fs-5">Melbourne</div>
															</div>
															<!--end::City-->
															<!--begin::Country-->
															<div class="d-flex flex-column gap-1">
																<div class="fw-bolder text-muted">Country</div>
																<div class="fw-bolder fs-5">Australia</div>
															</div>
															<!--end::Country-->
															<!--begin::Notes-->
															<div class="d-flex flex-column gap-1">
																<div class="fw-bolder text-muted">Notes</div>
																<p>Emma Smith joined the team on September 2019 as a junior associate. She soon showcased her expertise and experience in knowledge and skill in the field, which was very valuable to the company. She was promptly promoted to senior associate on July 2020.
																<br />
																<br />Emma Smith now heads a team of 5 associates and leads the company's sales growth by 7%.</p>
															</div>
															<!--end::Notes-->
														</div>
														<!--end::Additional details-->
													</div>
													<!--end:::Tab pane-->
													<!--begin:::Tab pane-->
													<div class="tab-pane fade" id="kt_contact_view_meetings" role="tabpanel">
														<!--begin::Dates-->
														<ul class="nav nav-pills d-flex flex-stack flex-nowrap hover-scroll-x">
															<!--begin::Date-->
															<li class="nav-item me-1">
																<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 text-dark text-active-white btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_0">
																	<span class="opacity-50 fs-7 fw-bold">Su</span>
																	<span class="fs-6 fw-bolder">22</span>
																</a>
															</li>
															<!--end::Date-->
															<!--begin::Date-->
															<li class="nav-item me-1">
																<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 text-dark text-active-white btn-active-primary active" data-bs-toggle="tab" href="#kt_schedule_day_1">
																	<span class="opacity-50 fs-7 fw-bold">Mo</span>
																	<span class="fs-6 fw-bolder">23</span>
																</a>
															</li>
															<!--end::Date-->
															<!--begin::Date-->
															<li class="nav-item me-1">
																<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 text-dark text-active-white btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_2">
																	<span class="opacity-50 fs-7 fw-bold">Tu</span>
																	<span class="fs-6 fw-bolder">24</span>
																</a>
															</li>
															<!--end::Date-->
															<!--begin::Date-->
															<li class="nav-item me-1">
																<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 text-dark text-active-white btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_3">
																	<span class="opacity-50 fs-7 fw-bold">We</span>
																	<span class="fs-6 fw-bolder">25</span>
																</a>
															</li>
															<!--end::Date-->
															<!--begin::Date-->
															<li class="nav-item me-1">
																<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 text-dark text-active-white btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_4">
																	<span class="opacity-50 fs-7 fw-bold">Th</span>
																	<span class="fs-6 fw-bolder">26</span>
																</a>
															</li>
															<!--end::Date-->
															<!--begin::Date-->
															<li class="nav-item me-1">
																<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 text-dark text-active-white btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_5">
																	<span class="opacity-50 fs-7 fw-bold">Fr</span>
																	<span class="fs-6 fw-bolder">27</span>
																</a>
															</li>
															<!--end::Date-->
															<!--begin::Date-->
															<li class="nav-item me-1">
																<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 text-dark text-active-white btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_6">
																	<span class="opacity-50 fs-7 fw-bold">Sa</span>
																	<span class="fs-6 fw-bolder">28</span>
																</a>
															</li>
															<!--end::Date-->
															<!--begin::Date-->
															<li class="nav-item me-1">
																<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 text-dark text-active-white btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_7">
																	<span class="opacity-50 fs-7 fw-bold">Su</span>
																	<span class="fs-6 fw-bolder">29</span>
																</a>
															</li>
															<!--end::Date-->
															<!--begin::Date-->
															<li class="nav-item me-1">
																<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 text-dark text-active-white btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_8">
																	<span class="opacity-50 fs-7 fw-bold">Mo</span>
																	<span class="fs-6 fw-bolder">30</span>
																</a>
															</li>
															<!--end::Date-->
															<!--begin::Date-->
															<li class="nav-item me-1">
																<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 text-dark text-active-white btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_9">
																	<span class="opacity-50 fs-7 fw-bold">Tu</span>
																	<span class="fs-6 fw-bolder">31</span>
																</a>
															</li>
															<!--end::Date-->
														</ul>
														<!--end::Dates-->
														<!--begin::Tab Content-->
														<div class="tab-content">
															<!--begin::Day-->
															<div id="kt_schedule_day_0" class="tab-pane fade show">
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-danger rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">11:00 - 11:45
																		<span class="fs-7 text-gray-400 text-uppercase">am</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Weekly Team Stand-Up</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Kendell Trevor</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-success rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">14:30 - 15:30
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">9 Degree Project Estimation Meeting</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">David Stevenson</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-primary rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">16:30 - 17:30
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Committee Review Approvals</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">David Stevenson</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
															</div>
															<!--end::Day-->
															<!--begin::Day-->
															<div id="kt_schedule_day_1" class="tab-pane fade show active">
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-warning rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">13:00 - 14:00
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Team Backlog Grooming Session</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Walter White</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-danger rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">12:00 - 13:00
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Development Team Capacity Review</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Bob Harris</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-info rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">16:30 - 17:30
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Weekly Team Stand-Up</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Caleb Donaldson</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
															</div>
															<!--end::Day-->
															<!--begin::Day-->
															<div id="kt_schedule_day_2" class="tab-pane fade show">
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-warning rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">13:00 - 14:00
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Marketing Campaign Discussion</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">David Stevenson</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-success rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">11:00 - 11:45
																		<span class="fs-7 text-gray-400 text-uppercase">am</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">9 Degree Project Estimation Meeting</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">David Stevenson</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-info rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">10:00 - 11:00
																		<span class="fs-7 text-gray-400 text-uppercase">am</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Marketing Campaign Discussion</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Peter Marcus</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
															</div>
															<!--end::Day-->
															<!--begin::Day-->
															<div id="kt_schedule_day_3" class="tab-pane fade show">
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-danger rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">14:30 - 15:30
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Weekly Team Stand-Up</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Yannis Gloverson</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-danger rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">10:00 - 11:00
																		<span class="fs-7 text-gray-400 text-uppercase">am</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Dashboard UI/UX Design Review</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Caleb Donaldson</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-primary rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">11:00 - 11:45
																		<span class="fs-7 text-gray-400 text-uppercase">am</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Development Team Capacity Review</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Michael Walters</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
															</div>
															<!--end::Day-->
															<!--begin::Day-->
															<div id="kt_schedule_day_4" class="tab-pane fade show">
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-danger rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">12:00 - 13:00
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Project Review &amp; Testing</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Karina Clarke</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-danger rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">9:00 - 10:00
																		<span class="fs-7 text-gray-400 text-uppercase">am</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Lunch &amp; Learn Catch Up</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Sean Bean</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-success rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">14:30 - 15:30
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Marketing Campaign Discussion</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Sean Bean</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
															</div>
															<!--end::Day-->
															<!--begin::Day-->
															<div id="kt_schedule_day_5" class="tab-pane fade show">
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-warning rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">14:30 - 15:30
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Development Team Capacity Review</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Caleb Donaldson</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-success rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">10:00 - 11:00
																		<span class="fs-7 text-gray-400 text-uppercase">am</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Dashboard UI/UX Design Review</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Yannis Gloverson</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-danger rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">11:00 - 11:45
																		<span class="fs-7 text-gray-400 text-uppercase">am</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Team Backlog Grooming Session</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Sean Bean</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
															</div>
															<!--end::Day-->
															<!--begin::Day-->
															<div id="kt_schedule_day_6" class="tab-pane fade show">
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-warning rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">11:00 - 11:45
																		<span class="fs-7 text-gray-400 text-uppercase">am</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Lunch &amp; Learn Catch Up</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Walter White</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-warning rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">13:00 - 14:00
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Lunch &amp; Learn Catch Up</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Sean Bean</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-success rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">10:00 - 11:00
																		<span class="fs-7 text-gray-400 text-uppercase">am</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Sales Pitch Proposal</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Peter Marcus</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
															</div>
															<!--end::Day-->
															<!--begin::Day-->
															<div id="kt_schedule_day_7" class="tab-pane fade show">
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-primary rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">12:00 - 13:00
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Committee Review Approvals</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Bob Harris</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-danger rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">12:00 - 13:00
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Dashboard UI/UX Design Review</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Terry Robins</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-success rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">16:30 - 17:30
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Lunch &amp; Learn Catch Up</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Terry Robins</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
															</div>
															<!--end::Day-->
															<!--begin::Day-->
															<div id="kt_schedule_day_8" class="tab-pane fade show">
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-danger rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">16:30 - 17:30
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Project Review &amp; Testing</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Kendell Trevor</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-success rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">11:00 - 11:45
																		<span class="fs-7 text-gray-400 text-uppercase">am</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Sales Pitch Proposal</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Kendell Trevor</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-primary rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">9:00 - 10:00
																		<span class="fs-7 text-gray-400 text-uppercase">am</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Team Backlog Grooming Session</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Sean Bean</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
															</div>
															<!--end::Day-->
															<!--begin::Day-->
															<div id="kt_schedule_day_9" class="tab-pane fade show">
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-warning rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">16:30 - 17:30
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Dashboard UI/UX Design Review</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Kendell Trevor</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-danger rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">12:00 - 13:00
																		<span class="fs-7 text-gray-400 text-uppercase">pm</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Dashboard UI/UX Design Review</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Peter Marcus</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
																<!--begin::Time-->
																<div class="d-flex flex-stack position-relative mt-8">
																	<!--begin::Bar-->
																	<div class="position-absolute h-100 w-4px bg-danger rounded top-0 start-0"></div>
																	<!--end::Bar-->
																	<!--begin::Info-->
																	<div class="fw-bold ms-5 text-gray-600">
																		<!--begin::Time-->
																		<div class="fs-5">10:00 - 11:00
																		<span class="fs-7 text-gray-400 text-uppercase">am</span></div>
																		<!--end::Time-->
																		<!--begin::Title-->
																		<a href="#" class="fs-5 fw-bolder text-gray-800 text-hover-primary mb-2">Development Team Capacity Review</a>
																		<!--end::Title-->
																		<!--begin::User-->
																		<div class="text-gray-400">Lead by
																		<a href="#">Caleb Donaldson</a></div>
																		<!--end::User-->
																	</div>
																	<!--end::Info-->
																	<!--begin::Action-->
																	<a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
																	<!--end::Action-->
																</div>
																<!--end::Time-->
															</div>
															<!--end::Day-->
														</div>
														<!--end::Tab Content-->
													</div>
													<!--end:::Tab pane-->
													<!--begin:::Tab pane-->
													<div class="tab-pane fade" id="kt_contact_view_activity" role="tabpanel">
														<!--begin::Timeline-->
														<div class="timeline-label">
															<!--begin::Item-->
															<div class="timeline-item">
																<!--begin::Label-->
																<div class="timeline-label fw-bolder text-gray-800 fs-6">08:42</div>
																<!--end::Label-->
																<!--begin::Badge-->
																<div class="timeline-badge">
																	<i class="fa fa-genderless text-warning fs-1"></i>
																</div>
																<!--end::Badge-->
																<!--begin::Text-->
																<div class="fw-mormal timeline-content text-muted ps-3">Outlines keep you honest. And keep structure</div>
																<!--end::Text-->
															</div>
															<!--end::Item-->
															<!--begin::Item-->
															<div class="timeline-item">
																<!--begin::Label-->
																<div class="timeline-label fw-bolder text-gray-800 fs-6">10:00</div>
																<!--end::Label-->
																<!--begin::Badge-->
																<div class="timeline-badge">
																	<i class="fa fa-genderless text-success fs-1"></i>
																</div>
																<!--end::Badge-->
																<!--begin::Content-->
																<div class="timeline-content d-flex">
																	<span class="fw-bolder text-gray-800 ps-3">AEOL meeting</span>
																</div>
																<!--end::Content-->
															</div>
															<!--end::Item-->
															<!--begin::Item-->
															<div class="timeline-item">
																<!--begin::Label-->
																<div class="timeline-label fw-bolder text-gray-800 fs-6">14:37</div>
																<!--end::Label-->
																<!--begin::Badge-->
																<div class="timeline-badge">
																	<i class="fa fa-genderless text-danger fs-1"></i>
																</div>
																<!--end::Badge-->
																<!--begin::Desc-->
																<div class="timeline-content fw-bolder text-gray-800 ps-3">Make deposit
																<a href="#" class="text-primary">USD 700</a>. to ESL</div>
																<!--end::Desc-->
															</div>
															<!--end::Item-->
															<!--begin::Item-->
															<div class="timeline-item">
																<!--begin::Label-->
																<div class="timeline-label fw-bolder text-gray-800 fs-6">16:50</div>
																<!--end::Label-->
																<!--begin::Badge-->
																<div class="timeline-badge">
																	<i class="fa fa-genderless text-primary fs-1"></i>
																</div>
																<!--end::Badge-->
																<!--begin::Text-->
																<div class="timeline-content fw-mormal text-muted ps-3">Indulging in poorly driving and keep structure keep great</div>
																<!--end::Text-->
															</div>
															<!--end::Item-->
															<!--begin::Item-->
															<div class="timeline-item">
																<!--begin::Label-->
																<div class="timeline-label fw-bolder text-gray-800 fs-6">21:03</div>
																<!--end::Label-->
																<!--begin::Badge-->
																<div class="timeline-badge">
																	<i class="fa fa-genderless text-danger fs-1"></i>
																</div>
																<!--end::Badge-->
																<!--begin::Desc-->
																<div class="timeline-content fw-bold text-gray-800 ps-3">New order placed
																<a href="#" class="text-primary">#XF-2356</a>.</div>
																<!--end::Desc-->
															</div>
															<!--end::Item-->
															<!--begin::Item-->
															<div class="timeline-item">
																<!--begin::Label-->
																<div class="timeline-label fw-bolder text-gray-800 fs-6">16:50</div>
																<!--end::Label-->
																<!--begin::Badge-->
																<div class="timeline-badge">
																	<i class="fa fa-genderless text-primary fs-1"></i>
																</div>
																<!--end::Badge-->
																<!--begin::Text-->
																<div class="timeline-content fw-mormal text-muted ps-3">Indulging in poorly driving and keep structure keep great</div>
																<!--end::Text-->
															</div>
															<!--end::Item-->
															<!--begin::Item-->
															<div class="timeline-item">
																<!--begin::Label-->
																<div class="timeline-label fw-bolder text-gray-800 fs-6">21:03</div>
																<!--end::Label-->
																<!--begin::Badge-->
																<div class="timeline-badge">
																	<i class="fa fa-genderless text-danger fs-1"></i>
																</div>
																<!--end::Badge-->
																<!--begin::Desc-->
																<div class="timeline-content fw-bold text-gray-800 ps-3">New order placed
																<a href="#" class="text-primary">#XF-2356</a>.</div>
																<!--end::Desc-->
															</div>
															<!--end::Item-->
															<!--begin::Item-->
															<div class="timeline-item">
																<!--begin::Label-->
																<div class="timeline-label fw-bolder text-gray-800 fs-6">10:30</div>
																<!--end::Label-->
																<!--begin::Badge-->
																<div class="timeline-badge">
																	<i class="fa fa-genderless text-success fs-1"></i>
																</div>
																<!--end::Badge-->
																<!--begin::Text-->
																<div class="timeline-content fw-mormal text-muted ps-3">Finance KPI Mobile app launch preparion meeting</div>
																<!--end::Text-->
															</div>
															<!--end::Item-->
														</div>
														<!--end::Timeline-->
													</div>
													<!--end:::Tab pane-->
												</div>
												<!--end::Tab content-->
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Contacts-->
									</div>
									<!--end::Content-->
								</div>
								<!--end::Contacts App- View Contact-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>
					<!--end::Content-->
                    <?php 
					$this->load->view("add_client");
					$this->load->view("add_contact");
					$this->load->view("add_campaign");
					?>
<script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/apps/user-management/users/list/add_contact.js">
	</script>

<script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/apps/user-management/users/list/add_campaign.js">
	</script>
		
					<script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/utilities/modals/create-project/persionalinfo.js"></script>
		<script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/utilities/modals/create-project/documents.js"></script>
		<script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/utilities/modals/create-project/classes.js"></script>
		<script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/utilities/modals/create-project/qualifications.js"></script>
		<script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/utilities/modals/create-project/experiences.js"></script>
		<script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/utilities/modals/create-project/files.js"></script>
		<script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/utilities/modals/create-project/complete.js"></script>
		<script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/utilities/modals/create-project/main.js"></script>
		<script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/utilities/modals/users-search.js"></script>