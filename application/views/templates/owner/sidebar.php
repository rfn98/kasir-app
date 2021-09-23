<!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?php echo base_url("assets/") ?>images/user.png" width="48" height="48" alt="User" />
                </div>
              
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0)" data-toggle="modal" data-target="#ubah_password"><i class="fa fa-lock"></i>Ubah kata sandi</a></li>
                            <li><a href="<?php echo base_url("init/logout") ?>"><i class="fa fa-sign-out"></i>Keluar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>

                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="fa fa-paste fa-fw fa-2x"></i>
                            <span>Cetak laporan</span>
                        </a>
                        <ul class="ml-menu">
                            <!-- <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Cards</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="pages/widgets/cards/basic.html">Basic</a>
                                    </li>
                                </ul>
                            </li> -->
                            <li>
                                <a href="javascript:void(0)" class="menu-toggle">Pelanggan</a>
                                <ul class="ml-menu">
                                    <li><a target="blank" href="<?php echo base_url('report/pdf/export/pelanggan') ?>">Pdf</a></li>
                                    <li><a href="javascript:void(0)" id="export" data-action="excel" data-export="pelanggan">Excel</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="menu-toggle">Menu</a>
                                <ul class="ml-menu">
                                    <li><a target="blank" href="<?php echo base_url('report/pdf/export/menu_resto') ?>">Pdf</a></li>
                                    <li><a href="javascript:void(0)" id="export" data-action="excel" data-export="menu_resto">Excel</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="menu-toggle">Pesanan</a>
                                <ul class="ml-menu">
                                    <li><a target="blank" href="<?php echo base_url('report/pdf/export/pesanan') ?>">Pdf</a></li>
                                    <li><a href="javascript:void(0)" id="export" data-action="excel" data-export="pesanan">Excel</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="menu-toggle">Transaksi</a>
                                <ul class="ml-menu">
                                    <li><a target="blank" href="<?php echo base_url('report/pdf/export/transaksi') ?>">Pdf</a></li>
                                    <li><a href="javascript:void(0)" id="export" data-action="excel" data-export="transaksi">Excel</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                
                    <li class="header">LABELS</li>
                    <li>
                     
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; <?= date("Y") ?> Aplikasi kasir</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>