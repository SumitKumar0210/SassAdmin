<div class="page-header">
            <div class="header-wrapper row m-0 gap-0">
              <div class="header-logo-wrapper col-auto p-0">
                <!-- <div class="logo-wrapper"><a href="index.html"><img class="img-fluid" src="{{asset('admin/assets/images/logo/logo-w.png')}}" alt=""></a></div> -->
                <div class="toggle-sidebar"><i data-feather="align-center"></i>
                  <div class="status_toggle middle sidebar-toggle">
                    <div class="header-left">
                      <form class="search-form mb-0">
                        <div class="input-group"><span class="input-group-text pe-0">
                            <svg class="search-bg svg-color"></svg></span>
                          <input class="form-control" type="search" placeholder="Search anything...">
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <form class="form-inline search-full" action="#" method="get">
                <div class="form-group w-100">
                  <div class="Typeahead Typeahead--twitterUsers">
                    <div class="u-posRelative">
                      <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search Boho .." name="q" title="" autofocus>
                      <svg class="search-bg svg-color">
                        <use href="{{asset('admin/assets/svg/icon-sprite.svg')}}#search"></use>
                      </svg>
                    </div>
                    <div class="Typeahead-menu"></div>
                  </div>
                </div>
              </form>
              <div class="nav-right col-auto pull-right right-header p-0 ms-auto">
                <ul class="nav-menus">
                  <li class="onhover-dropdown search-box">
                    <div class="search header-search">
                      <svg>
                        <use href="{{asset('admin/assets/svg/icon-sprite.svg')}}#search"></use>
                      </svg>
                    </div>
                    <div class="search-input">
                      <input class="Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search Boho .." name="q" title="">
                    </div>
                  </li>
                  <li class="onhover-dropdown">
                    <div class="notification-box animated">
                      <svg>
                        <use href="{{asset('admin/assets/svg/icon-sprite.svg')}}#notification"></use>
                      </svg>
                    </div>
                    <div class="onhover-show-div notification-dropdown">
                      <h3 class="f-18 mb-0 dropdown-title">Notitications                               </h3>
                      <ul>
                        <li class="b-t-primary border-4">
                          <p><a href="../template/product.html">Delivery processing  </a><span class="font-danger">10 min.</span></p>
                        </li>
                        <li class="b-t-success border-4">
                          <p><a href="../template/order-history.html">Order Complete</a><span class="font-success">1 hr</span></p>
                        </li>
                        <li class="b-t-secondary border-4">
                          <p><a href="../template/checkout.html">Tickets Generated</a><span class="font-secondary">3 hr</span></p>
                        </li>
                        <li class="b-t-warning border-4">
                          <p><a href="../template/list-products.html">Delivery Complete</a><span class="font-warning">6 hr</span></p>
                        </li>
                        <li class="check-button p-0"><a class="f-w-500" href="#">Check all</a></li>
                      </ul>
                    </div>
                  </li>
                  <li>
                    <div class="mode">
                      <svg>
                        <use href="{{asset('admin/assets/svg/icon-sprite.svg')}}#moon"></use>
                      </svg>
                    </div>
                  </li>
                  <li class="onhover-dropdown">
                    <svg>
                      <use href="{{asset('admin/assets/svg/icon-sprite.svg')}}#star"></use>
                    </svg>
                    <div class="onhover-show-div bookmark-flip">
                      <div class="flip-card">
                        <div class="flip-card-inner">
                          <div class="front">
                            <h3 class="f-18 mb-0 dropdown-title">Bookmark</h3>
                            <ul class="bookmark-dropdown">
                              <li>
                                <div class="row">
                                  <div class="col-4 text-center"><a href="../template/form-validation.html"> 
                                      <div class="bookmark-content">
                                        <div class="bookmark-icon"><i data-feather="file-text"></i></div><span class="f-w-700 mt-2">Forms</span>
                                      </div></a></div>
                                  <div class="col-4 text-center"><a href="../template/email-application.html">
                                      <div class="bookmark-content">
                                        <div class="bookmark-icon"><i data-feather="user"></i></div><span class="f-w-700 mt-2">Profile</span>
                                      </div></a></div>
                                  <div class="col-4 text-center"><a href="../template/email-application.html">
                                      <div class="bookmark-content">
                                        <div class="bookmark-icon"><i data-feather="server"></i></div><span class="f-w-700 mt-2">Tables</span>
                                      </div></a></div>
                                </div>
                              </li>
                              <li class="text-centermedia-body check-button mt-0"> <a class="flip-btn f-w-500" id="flip-btn" href="javascript:void(0)">Add New Bookmark</a></li>
                            </ul>
                          </div>
                          <div class="back">
                            <ul>
                              <li>
                                <div class="bookmark-dropdown flip-back-content">
                                  <input type="text" placeholder="search...">
                                </div>
                              </li>
                              <li class="check-button"><a class="f-w-500 d-block flip-back" id="flip-back" href="javascript:void(0)">Back</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="onhover-dropdown">
                    <div class="notification-box">
                      <svg>
                        <use href="{{asset('admin/assets/svg/icon-sprite.svg')}}#Message"></use>
                      </svg><span class="badge rounded-pill badge-secondary"> </span>
                    </div>
                    <div class="onhover-show-div">
                      <h3 class="f-18 mb-0 dropdown-title">Message</h3>
                      <ul class="message-box">
                        <li>
                          <div class="d-flex">
                            <div class="flex-shrink-0 bg-primary"><i class="fa fa-check-circle"></i></div>
                            <div class="flex-grow-1"> <a href="../template/chat.html"> 
                                <h4>Helen Walter</h4>
                                <p>Hi , Helen</p></a></div><span>10 min.</span>
                          </div>
                        </li>
                        <li>
                          <div class="d-flex">
                            <div class="flex-shrink-0 bg-secondary"><i class="fa fa-exclamation-circle"></i></div>
                            <div class="flex-grow-1"> <a href="../template/chat.html">
                                <h4>Vincent Porter</h4>
                                <p>Change for anyone.</p></a></div><span>35 min.</span>
                          </div>
                        </li>
                        <li>
                          <div class="d-flex">
                            <div class="flex-shrink-0 bg-success"><i class="fa fa-times-circle"></i></div>
                            <div class="flex-grow-1"> <a href="../template/chat.html">
                                <h4>Ginger Johnston</h4>
                                <p>Hello Name</p></a></div><span>50 min.</span>
                          </div>
                        </li>
                        <li>
                          <div class="d-flex">
                            <div class="flex-shrink-0 bg-warning"><i class="fa fa-check-circle"></i></div>
                            <div class="flex-grow-1"> <a href="../template/chat.html">
                                <h4>Kori Thomas</h4>
                                <p>Well I am not sure.</p></a></div><span>27 min.</span>
                          </div>
                        </li>
                        <li class="pb-0 mt-3 check-button"><a class="f-w-500" href="#">Check all</a></li>
                      </ul>
                    </div>
                  </li>
                  <li class="cart-nav onhover-dropdown">
                    <div class="cart-box">
                      <svg>
                        <use href="{{asset('admin/assets/svg/icon-sprite.svg')}}#stroke-ecommerce"></use>
                      </svg>
                    </div>
                    <div class="cart-dropdown onhover-show-div">
                      <h3 class="f-18 mb-0 dropdown-title">Cart</h3>
                      <ul>
                        <li>
                          <div class="d-flex"><img class="img-fluid b-r-5 me-3 img-60" src="{{asset('admin/assets/images/dashboard-2/product/1.png')}}" alt="">
                            <div class="flex-grow-1"><a href="../template/product.html"> <span>Furniture Chair for Home</span></a>
                              <div class="qty-box">
                                <div class="input-group"><span class="input-group-prepend">
                                    <button class="btn quantity-left-minus" type="button" data-type="minus" data-field="">-</button></span>
                                  <input class="form-control input-number f-14 f-w-500" type="text" name="quantity" value="1"><span class="input-group-prepend">
                                    <button class="btn quantity-right-plus" type="button" data-type="plus" data-field="">+</button></span>
                                </div>
                              </div>
                              <h5 class="font-primary">$500</h5>
                            </div>
                            <div class="close-circle"><a class="bg-danger" href="#"><i data-feather="x"></i></a></div>
                          </div>
                        </li>
                        <li>
                          <div class="d-flex"><img class="img-fluid b-r-5 me-3 img-60" src="{{asset('admin/assets/images/dashboard-2/product/2.png')}}" alt="">
                            <div class="flex-grow-1"><a href="../template/product.html"> <span>The best office table</span></a>
                              <div class="qty-box">
                                <div class="input-group"> <span class="input-group-prepend">
                                    <button class="btn quantity-left-minus" type="button" data-type="minus" data-field="">-</button></span>
                                  <input class="form-control input-number f-14 f-w-500" type="text" name="quantity" value="1"><span class="input-group-prepend">
                                    <button class="btn quantity-right-plus" type="button" data-type="plus" data-field="">+</button></span>
                                </div>
                              </div>
                              <h5 class="font-primary">$500.00</h5>
                            </div>
                            <div class="close-circle"><a class="bg-danger" href="#"><i data-feather="x"></i></a></div>
                          </div>
                        </li>
                        <li class="total">
                          <h6 class="mb-0">Order Total : <span class="f-right f-w-700">$1000.00</span></h6>
                        </li>
                        <li> <a class="d-block view-cart text-center f-w-700" href="../template/cart.html">Go to your cart</a></li>
                        <li class="text-center check-button"><a class="btn btn-primary view-checkout" href="../template/checkout.html">Checkout  </a></li>
                      </ul>
                    </div>
                  </li>
                  <li class="language-nav">
                    <div class="translate_wrapper">
                      <div class="current_lang">
                        <div class="lang"><i class="flag-icon flag-icon-gb"></i><span class="lang-txt">EN                               </span></div>
                      </div>
                      <div class="more_lang">
                        <div class="lang selected" data-value="en"><i class="flag-icon flag-icon-us"></i><span class="lang-txt">English<span> (US)</span></span></div>
                        <div class="lang" data-value="de"><i class="flag-icon flag-icon-de"></i><span class="lang-txt">Deutsch</span></div>
                        <div class="lang" data-value="es"><i class="flag-icon flag-icon-es"></i><span class="lang-txt">Español</span></div>
                        <div class="lang" data-value="fr"><i class="flag-icon flag-icon-fr"></i><span class="lang-txt">Français</span></div>
                        <div class="lang" data-value="pt"><i class="flag-icon flag-icon-pt"></i><span class="lang-txt">Português<span> (BR)</span></span></div>
                        <div class="lang" data-value="cn"><i class="flag-icon flag-icon-cn"></i><span class="lang-txt">简体中文</span></div>
                        <div class="lang" data-value="am"><i class="flag-icon flag-icon-am"></i><span class="lang-txt">لعربية <span> (ae)</span></span></div>
                      </div>
                    </div>
                  </li>
                  <li class="profile-nav onhover-dropdown pe-0 py-0">
                    <div class="d-flex profile-media"><img src="{{asset('admin/assets/images/profile.png')}}" alt="">
                      <div class="flex-grow-1"><span>Helen Walter</span>
                        <p class="mb-0 font-roboto">Admin <i class="middle fa fa-angle-down"></i></p>
                      </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
                      <li><a href="../template/user-profile.html"><i data-feather="user"></i><span>Account </span></a></li>
                      <li><a href="../template/email-application.html"><i data-feather="mail"></i><span>Inbox</span></a></li>
                      <li><a href="../template/task.html"><i data-feather="file-text"></i><span>Taskboard</span></a></li>
                      <li><a href="../template/edit-profile.html"><i data-feather="settings"></i><span>Settings</span></a></li>
                      <li><a href="../template/login.html"><i data-feather="log-in"> </i><span>Log in</span></a></li>
                    </ul>
                  </li>
                </ul>
              </div>
              <script class="result-template" type="text/x-handlebars-template">
                <div class="ProfileCard u-cf">                        
                <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
                <div class="ProfileCard-details">
                <div class="ProfileCard-realName">Name</div>
                </div>
                </div>
              </script>
              <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
            </div>
          </div>