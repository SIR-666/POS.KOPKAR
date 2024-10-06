<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://localhost:8080/kopkar/pos/assets/img/profil/cart.png" rel="icon">
    <title>Penjualan | POS</title>
    <link href="http://localhost:8080/kopkar/pos/assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://localhost:8080/kopkar/pos/assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://localhost:8080/kopkar/pos/assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="http://localhost:8080/kopkar/pos/assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="http://localhost:8080/kopkar/pos/assets/build/css/custom.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="select2/dist/css/select2.min.css"> -->
    <link rel="stylesheet" type="text/css" href="http://localhost:8080/kopkar/pos/assets/DataTables/datatables.min.css" />
    <link href="http://localhost:8080/kopkar/pos/assets/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="http://localhost:8080/kopkar/pos/assets/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://localhost:8080/kopkar/pos/assets/sweetalert2/dist/sweetalert2.min.css" />
    <script src="http://localhost:8080/kopkar/pos/assets/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="http://localhost:8080/kopkar/pos/assets/select2/select2.css" type="text/css" />
    <link rel="stylesheet" href="http://localhost:8080/kopkar/pos/assets/icomoon/styles.css" type="text/css" />
    <link href="http://localhost:8080/kopkar/pos/assets/vendors/switchery/dist/switchery.min.css" rel="stylesheet">

</head>
<script>
    var base_url = "http://localhost:8080/kopkar/pos/";
</script>

<body class="nav-md" onLoad="OnLoadForm()">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="#" class="site_title"><i class="fa fa-shopping-cart" style="color:white"></i> <span style="color: white;font: size 16px;">Greenfields</span></a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="http://localhost:8080/kopkar/pos/assets/production/images/user.png" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>Administrator</h2>
                        </div>
                    </div>
                    <br />
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="http://localhost:8080/kopkar/pos/dashboard">Dashboard</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-shopping-cart"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="http://localhost:8080/kopkar/pos/penjualan">Entry Penjualan</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/dpenjualan">Daftar Penjualan</a></li>

                                        <li><a href="http://localhost:8080/kopkar/pos/pembelian">Entry Pembelian</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/dpembelian">Daftar Pembelian</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/hutang">Hutang</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/piutang">Piutang</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/posting">Posting Jurnal</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-desktop"></i> Master Data <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="http://localhost:8080/kopkar/pos/barang">Data Barang</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/kategori">Data Kategori Barang</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/satuan">Data Satuan Barang</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/supplier">Data Supplier</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/customer">Data Anggota</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/karyawan">Data Karyawan</a></li>
                                        <!-------------------------------------------------------------------
                        <li><a href="">Data Servis</a></li>
                        --------------------------------------------------------------------->
                                        <!-- <li><a href="">Mutasi Barang</a></li> -->
                                        <li><a href="http://localhost:8080/kopkar/pos/stokopname">Stok Opname</a></li>
                                        <!---------------------------------------------------------------------
                        <li><a href="">Stok In/Out</a></li>
                        <li><a href="">Data Gudang</a></li>
                        ---------------------------------------------------------------------->
                                    </ul>
                                </li>

                                <!--  <li><a><i class="fa fa-money"></i> Keuangan <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="">Kas</a></li>
                        <li><a href="">PPN</a></li>
                        <li><a href="">Bank</a></li>
                      </ul>
                    </li> -->

                                <li><a><i class="fa fa-file-text-o"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="http://localhost:8080/kopkar/pos/laporan/barang">Laporan Barang</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/Barang/Kartu_barang">Kartu Barang</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/laporan/penjualan">Laporan Penjualan</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/laporan/Rekap_penjualan">Rekap Penjualan</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/Laporan/Laporan_kategori">Laporan Penjualan Kategori</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/laporan/pembelian">Laporan Pembelian</a></li>
                                        <!-- <li><a href="">Laporan Mutasi Barang</a></li> -->
                                        <li><a href="http://localhost:8080/kopkar/pos/laporan/stokopname">Laporan Stok Opname</a></li>
                                        <!-----------------------------------------------------------------------------------
                        <li><a href="">Laporan Laba Rugi</a></li>
                        ------------------------------------------------------------------------------------->
                                        <li><a href="http://localhost:8080/kopkar/pos/laporan/kas">Laporan Kas</a></li>
                                        <!-----------------------------------------------------------------------------------
                        <li><a href="">Laporan Kas Bank</a></li>
                        <li><a href="">Laporan Stok In/Out</a></li>
                        ------------------------------------------------------------------------------------->
                                        <li><a href="http://localhost:8080/kopkar/pos/laporan/hutang">Laporan Hutang</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/laporan/piutang">Laporan Piutang</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-user"></i> Management User <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="http://localhost:8080/kopkar/pos/user">Data User</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/userlog">User Log</a></li>
                                    </ul>
                                </li>

                                <li><a><i class="fa fa-bar-chart-o"></i> Grafik <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="http://localhost:8080/kopkar/pos/grafik">Grafik</a></li>
                                    </ul>
                                </li>
                                <!------------------------------------------------------------------------------------------------
                    <li><a><i class="fa fa-magic"></i> Tools <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">
                        <li><a href="http://localhost:8080/kopkar/pos/barcode">Generate Barcode</a></li>
                        <li><a href="http://localhost:8080/kopkar/pos/backup">Backup Data</a></li>
                        <li><a href="http://localhost:8080/kopkar/pos/applog">Application Log</a></li>
                      </ul>
                    </li>s
        
                    <li><a><i class="fa fa-gift"></i> Prestasi <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="">Index Prestasi</a></li>
                      </ul>
                    </li>
                    ---------------------------------------------------------------------------------------------------->
                                <li><a><i class="fa fa-gears"></i> Setting <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="http://localhost:8080/kopkar/pos/profil">Profil Toko</a></li>
                                        <li><a href="http://localhost:8080/kopkar/pos/Poscoa">Setup Chart of account</a></li>
                                        <!-- <li><a href="">Setting Promo</a></li> -->
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div> <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars" style="color:white;"></i></a>
                        </div>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="http://localhost:8080/kopkar/pos/assets/production/images/user.png" alt=""> <span style="color: white;">Administrator</span>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href="http://localhost:8080/kopkar/pos/user/change_password"><i class="fa fa-key pull-right"></i> Ubah Password</a></li>
                                    <li><a href="http://localhost:8080/kopkar/pos/auth/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                </ul>
                            </li>

                            <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o" style="color:white;"></i>
                                    <span class=" badge bg-green">6</span>
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                    <li>
                                        <a>
                                            <span class="image"><img src="http://localhost:8080/kopkar/pos/assets/production/images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image"><img src="http://localhost:8080/kopkar/pos/assets/production/images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image"><img src="http://localhost:8080/kopkar/pos/assets/production/images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image"><img src="http://localhost:8080/kopkar/pos/assets/production/images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="text-center">
                                            <a>
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>Penjualan</h3>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h2 style="text-align: right"> Invoice <b id="invoice"></b></h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-9 col-sm-12 col-xs-12">
                                            <h1>Total (Rp)</h1>
                                        </div>
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <h1 style="text-align: right" id="subtot"> 0</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form class="form-horizontal" method="post" action="http://localhost:8080/kopkar/pos/penjualan/simpanpenjualan">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" name="idoperator" id="idoperator" readonly value="1">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Operator</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" class="form-control" name="operator" id="operator" readonly value="Administrator">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Anggota</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <select id="customer" name="customer" class="form-control select2" onChange="SetBolehKredit()" required>
                                                    <option value="0">Umum</option>
                                                    <option value="10">PUPUT MUSTHOQOLIFAH</option>
                                                    <option value="11">FARIDA SRI WAHYUNINGSIH</option>
                                                    <option value="12">NAILA RACHMATIKA</option>
                                                    <option value="13">ENI SRI LESTARI</option>
                                                    <option value="14">MOCH. SAIFULLOH</option>
                                                    <option value="15">FRANSISKA NANINGTYAS</option>
                                                    <option value="16">YETI INDRAWATI</option>
                                                    <option value="17">MARINA</option>
                                                    <option value="18">CARTENS JANSEN</option>
                                                    <option value="19">JAKA AHMAD JULIARTA</option>
                                                    <option value="21">EUIS LISNAWATI</option>
                                                    <option value="22">RONALDDO PARULINA</option>
                                                    <option value="23">EKA ADITYA</option>
                                                    <option value="25">YUNITA RESTY DAMAYANTI</option>
                                                    <option value="26">ARDIANSAH</option>
                                                    <option value="27">CHRISTY BETJE</option>
                                                    <option value="28">LUSY ARINDA</option>
                                                    <option value="29">DINI PURWAHYUNINGSIH</option>
                                                    <option value="30">MOHAMAD RIDWAN</option>
                                                    <option value="31">TAUFIK SEPTIYANTO</option>
                                                    <option value="32">ROBBY SASHUDI</option>
                                                    <option value="33">MUHAMMAD UDIN HARIANTO</option>
                                                    <option value="34">NORMA FABIAN S</option>
                                                    <option value="35">FARID KRISSANDY</option>
                                                    <option value="36">MISBAKHUL MUNIR</option>
                                                    <option value="37">YUSAKHIRIL LUKMAN</option>
                                                    <option value="38">AHMAD SARONI</option>
                                                    <option value="39">DODY AGUS PRASMANA</option>
                                                    <option value="40">TOHIRIN</option>
                                                    <option value="41">AVIDA NUR HIDAYAH</option>
                                                    <option value="42">PUNGKY ARTIWI</option>
                                                    <option value="43">IRVANSYAH GILAND R</option>
                                                    <option value="44">ARIFNI CHOIRUSSABILA</option>
                                                    <option value="45">NOVIANA IKA SETYANINGRUM</option>
                                                    <option value="46">RISFA NURROHMAN</option>
                                                    <option value="47">FAUZUL ADIM</option>
                                                    <option value="48">ANDI WIJAYA</option>
                                                    <option value="49">PETRIO CATUR RETBIANTORO</option>
                                                    <option value="50">ERWIN FERDIAN</option>
                                                    <option value="51">ARI ISNADI</option>
                                                    <option value="53">BAYU NOVI MOCHAMMAD NUR</option>
                                                    <option value="54">CAHYONO</option>
                                                    <option value="55">TOMMY ZULKIFLI</option>
                                                    <option value="56">RAFI WULYANTO</option>
                                                    <option value="57">CHANDRA WAHYUDI</option>
                                                    <option value="58">DANANG GALIH P.</option>
                                                    <option value="59">DENI HARIJAYA</option>
                                                    <option value="60">DONNI SUSANTO</option>
                                                    <option value="61">EKA SUSILOWATI</option>
                                                    <option value="62">HERI SUPRAPTO</option>
                                                    <option value="63">HERI TRI SANTOSO</option>
                                                    <option value="64">HERWANTO</option>
                                                    <option value="65">ANDIK NAUFAL AFIF</option>
                                                    <option value="66">IDAWATI </option>
                                                    <option value="67">IMAM MUSLIM</option>
                                                    <option value="68">LADIONO</option>
                                                    <option value="69">EKO WAHYU NURDIANSYAH</option>
                                                    <option value="70">TRI YOGA FARDIANTO</option>
                                                    <option value="71">EDO PRASETYO UTOMO</option>
                                                    <option value="72">GUNTUR MAYHENDRA</option>
                                                    <option value="73">DODIK IRAWAN</option>
                                                    <option value="74">BAYU EKO WIDODO</option>
                                                    <option value="75">DIDIK DIMAS M</option>
                                                    <option value="76">MOCH AINUL HAKIM</option>
                                                    <option value="77">MOCHAMAD TATOK EFENDI</option>
                                                    <option value="78">NURKOLIS</option>
                                                    <option value="79">NUR SIDIQ</option>
                                                    <option value="81">SETIA BUDI</option>
                                                    <option value="82">CHANDRA ISLAMAWAN</option>
                                                    <option value="83">M. NUR KHOLIS</option>
                                                    <option value="84">SANDY EDGAR A</option>
                                                    <option value="85">IRVAN ADHE P</option>
                                                    <option value="86">SULTON ALI ZAMZAM</option>
                                                    <option value="87">AHMAD DENI RIAFAN</option>
                                                    <option value="88">ROUFU ROKHIM</option>
                                                    <option value="89">RUSWANTO</option>
                                                    <option value="90">SUDARWANTO</option>
                                                    <option value="91">RIZXI REDA ARIF</option>
                                                    <option value="92">SUHARTONO</option>
                                                    <option value="93">SUYONO A</option>
                                                    <option value="94">TEGUH IMAN SANTOSO</option>
                                                    <option value="95">TEGUH ISTIONO</option>
                                                    <option value="96">SUGIYONO</option>
                                                    <option value="97">YULIANTO</option>
                                                    <option value="98">EKO SAPUTRA</option>
                                                    <option value="99">YUSUF AGUS PRASTOMO</option>
                                                    <option value="100">SUTRIS KURNIAWAN</option>
                                                    <option value="101">DIDIK YULIANTO</option>
                                                    <option value="102">NURIANTO</option>
                                                    <option value="103">SUYONO B</option>
                                                    <option value="104">WIDI DARIANTO</option>
                                                    <option value="105">WAWAN SETIAWAN</option>
                                                    <option value="106">SUNARTO </option>
                                                    <option value="107">SUPRIADI A</option>
                                                    <option value="108">LUKMAN EFFENDI</option>
                                                    <option value="109">WIBOWO</option>
                                                    <option value="110">FEBRI KRISDIANTORO</option>
                                                    <option value="111">YULIANTO B</option>
                                                    <option value="112">INDRA WIJAYA</option>
                                                    <option value="113">PRIYONO LESTARI </option>
                                                    <option value="114">ERRIK EXWANDA</option>
                                                    <option value="115">KHOIRUL ARIFIN </option>
                                                    <option value="116">SUPRIADI B</option>
                                                    <option value="117">IDIK VERYANTO</option>
                                                    <option value="119">TRIO APRILIANTO</option>
                                                    <option value="120">ZAINAL ARIFIN</option>
                                                    <option value="121">JOHAN PRASTYO</option>
                                                    <option value="122">NAWAF ARIFIN SHOLIH</option>
                                                    <option value="123">EKA WAHYU OKTA R S</option>
                                                    <option value="124">MOHAMAD CHOIRUL AMINUDIN</option>
                                                    <option value="125">DHENY SATYA PRAYUDHA</option>
                                                    <option value="126">ACHMAD NUR HASAN</option>
                                                    <option value="127">MUHAMMAD FARIDUS SHOLEH</option>
                                                    <option value="128">HARIADI</option>
                                                    <option value="129">WASKITO BUDI SETIAWAN</option>
                                                    <option value="130">ELSA SURYA ADITYA</option>
                                                    <option value="131">DWI WAHYU UTOMO</option>
                                                    <option value="132">ACHMAD EFFENDY</option>
                                                    <option value="133">MOCH. BAYU WARDHANA</option>
                                                    <option value="134">KIKI HANDOKO</option>
                                                    <option value="135">HADI SANCOKO</option>
                                                    <option value="136">DOFI LALANG SETYAWAN</option>
                                                    <option value="137">KHAFID MINANUROHMAN</option>
                                                    <option value="138">DENI KRISWANTO</option>
                                                    <option value="139">ANDIK SUGIANTO</option>
                                                    <option value="140">FREDY PRATAMA</option>
                                                    <option value="141">ANDOYO</option>
                                                    <option value="142">ANGGA YUNIAN PUTRA</option>
                                                    <option value="143">ALI MAHRUF</option>
                                                    <option value="144">AINUL YAKIN OKTADIANTO</option>
                                                    <option value="145">ANWAR ROFIQ</option>
                                                    <option value="146">DIMAS ANDRIAN TRI LAKSONO</option>
                                                    <option value="147">SUKARDI</option>
                                                    <option value="148">E R PUSPITA SARI</option>
                                                    <option value="149">HIDAYATUL IZZA MUFASIROH</option>
                                                    <option value="150">SYAMSUL HADI</option>
                                                    <option value="152">SUSILO UTOMO</option>
                                                    <option value="153">TOSAN SUGENG PURNOMO</option>
                                                    <option value="154">YAN ARDIANTO</option>
                                                    <option value="155">HAMAM ABI ANDRIKA LUTFI</option>
                                                    <option value="157">HARIYATI, AMD</option>
                                                    <option value="158">RICKY ADI SANJA</option>
                                                    <option value="159">ADI NUGROHO</option>
                                                    <option value="160">INDRA CAHYA</option>
                                                    <option value="161">IRMA LESYANA</option>
                                                    <option value="162">IMANUEL GIDION KURNIAWAN</option>
                                                    <option value="164">GHALIB PUTRA SETIAWAN</option>
                                                    <option value="165">DEDY PURWANA ARYONO </option>
                                                    <option value="166">MUHAMMAD SULKAN</option>
                                                    <option value="167">DARSONO</option>
                                                    <option value="168">ZUH ROHTUL AULIA</option>
                                                    <option value="169">EDY WINARTO</option>
                                                    <option value="170">SOLEH PRASETYO</option>
                                                    <option value="171">IWAN PURWANTO PRASETYO</option>
                                                    <option value="172">JOKO YUSEFA</option>
                                                    <option value="173">MINTO</option>
                                                    <option value="174">RIO OKTA PRIYAMBODO</option>
                                                    <option value="175">SAIFUL IMAM S.P</option>
                                                    <option value="176">SUGIONO, STP</option>
                                                    <option value="177">TATOK KRISWANTO</option>
                                                    <option value="178">YENI ANDRIANI</option>
                                                    <option value="179">TANTO SUPRIANTO</option>
                                                    <option value="180">FRYSA ERIDANA</option>
                                                    <option value="181">ROCHMAD</option>
                                                    <option value="182">YULIONO HADI P.</option>
                                                    <option value="183">MUHAMMAD YANU</option>
                                                    <option value="184">DWI PUTRANTO SULYANDOKO</option>
                                                    <option value="185">JAMALUDIN</option>
                                                    <option value="186">MUHAMAD AINUL BUSRO</option>
                                                    <option value="187">AJI YAHNUAR PRASETYO</option>
                                                    <option value="188">RIYANTO</option>
                                                    <option value="189">RONNY HARI PRASETYONO</option>
                                                    <option value="190">SOKHEH YUSUF</option>
                                                    <option value="191">SUBROTO</option>
                                                    <option value="192">SUHERMAN HASAN</option>
                                                    <option value="193">SUMARDI</option>
                                                    <option value="194">TARMUJIONO</option>
                                                    <option value="195">YUDI EKO PRABOWO</option>
                                                    <option value="196">ARIEF MUSTHOFA, STP</option>
                                                    <option value="197">ZONI WIRAWAN</option>
                                                    <option value="199">DYAH RATRI RAHADINI</option>
                                                    <option value="200">SUNGKONO</option>
                                                    <option value="201">PRIYO HARDIYANTO</option>
                                                    <option value="202">DEVIDSON LODU</option>
                                                    <option value="203">RAHPUAN KATK</option>
                                                    <option value="204">NURYAFAN WIJAYA</option>
                                                    <option value="205">FIRDA RAHMATIKA</option>
                                                    <option value="206">MAHMUDIN</option>
                                                    <option value="207">TANADI</option>
                                                    <option value="208">WAHYUDI ALUTFI</option>
                                                    <option value="209">SATRIO CHABIBI FEBRIANTO</option>
                                                    <option value="210">LUDY PUTRA A</option>
                                                    <option value="211">FARID AGUS PRIADI</option>
                                                    <option value="212">YUHADIANTO</option>
                                                    <option value="213">SUGENG MIYARSO</option>
                                                    <option value="214">HERU ATMA WIJAYA</option>
                                                    <option value="215">DADANG WICAKSONO</option>
                                                    <option value="216">ANDI SURYO PUTRO</option>
                                                    <option value="217">MOCH. INDRIYANSAH</option>
                                                    <option value="218">ARRAY SIDI TIRTANA</option>
                                                    <option value="219">WAHYU TRI ADIVIA</option>
                                                    <option value="220">OKKY SULISTIAWAN</option>
                                                    <option value="221">AHMAD YASIN</option>
                                                    <option value="222">AMINUDIN</option>
                                                    <option value="223">ANDIK ATMAJA</option>
                                                    <option value="224">ANDIK SUSANTO</option>
                                                    <option value="225">ANAS KISWANTO</option>
                                                    <option value="226">BAGUS JANURI</option>
                                                    <option value="227">DWI IKE SETYAWAN</option>
                                                    <option value="228">EKA DIRINDA WANGSA</option>
                                                    <option value="229">MOHAMAD ERIK JUNAEDY</option>
                                                    <option value="230">YUDHI ARIFIANTO</option>
                                                    <option value="231">HAIRULLAH HASAN NUR </option>
                                                    <option value="232">HALLYS SUDIRMAN</option>
                                                    <option value="233">THEO ALFA CHANDRA K</option>
                                                    <option value="234">KARJONO</option>
                                                    <option value="235">RIFAI SANTOSO</option>
                                                    <option value="236">ROHMAT FAMUJI</option>
                                                    <option value="237">SETIYO BUDI ANDRIAN</option>
                                                    <option value="238">SLAMET BUDIARTO</option>
                                                    <option value="239">SUPADNO</option>
                                                    <option value="240">TRI PUGUH WIDODO</option>
                                                    <option value="241">WINARTO</option>
                                                    <option value="242">DAVID SETYA GUNAWAN</option>
                                                    <option value="243">WIYATNO</option>
                                                    <option value="244">YANWARI BASUKI WIDODO</option>
                                                    <option value="245">YUNITA SUZAN</option>
                                                    <option value="246">EVA YULIANA ARI WARDHANI</option>
                                                    <option value="247">HERI SUKOCO</option>
                                                    <option value="248">DIDIK HARDIYANTO</option>
                                                    <option value="249">SEVIAN SAPUTRO</option>
                                                    <option value="250">MISDIANTO</option>
                                                    <option value="251">GALIH ZHENDY PURNAMA</option>
                                                    <option value="252">ANSORI</option>
                                                    <option value="253">AGUS SETYAWAN</option>
                                                    <option value="254">WIDODO SETIAWAN</option>
                                                    <option value="255">SUPRIYANTO</option>
                                                    <option value="256">HERU SUMARDIONO</option>
                                                    <option value="257">YOYOK SUSANTO</option>
                                                    <option value="258">HERI MUJI SANTOSO</option>
                                                    <option value="259">ROY WAHONO</option>
                                                    <option value="260">RAGILLIONO PANCA ABADI</option>
                                                    <option value="261">YUDIANTO</option>
                                                    <option value="263">EXFAL</option>
                                                    <option value="264">BAGAS PRAKASA</option>
                                                    <option value="265">MUCHLIS ARIFIN</option>
                                                    <option value="266">MUHAMAD ARIYANTO</option>
                                                    <option value="267">DWI HARI PRAMONO</option>
                                                    <option value="268">SUPRAYITNO</option>
                                                    <option value="269">DWI PRASETYO ADI</option>
                                                    <option value="270">CANDRA ISWAHYUDI</option>
                                                    <option value="271">MAMIK SLAMET</option>
                                                    <option value="272">DIDIK SETYANA ADI</option>
                                                    <option value="273">DEDI VEKTOR PRAMONO</option>
                                                    <option value="274">ACHMADI IRVAN WIJAYA</option>
                                                    <option value="275">DARSONO (UHT)</option>
                                                    <option value="276">DEDI IRAWAN</option>
                                                    <option value="277">AGUS SAIFULIS</option>
                                                    <option value="278">AKMAL ADYARAZAN</option>
                                                    <option value="279">CHOIRUL ANAM</option>
                                                    <option value="280">YUDHO LESTARI DWI P</option>
                                                    <option value="281">BUDI SETIAWAN</option>
                                                    <option value="282">TEDDY SURYO PRAYOGO</option>
                                                    <option value="283">KURNIAWAN</option>
                                                    <option value="284">DADING SATKWANTONO</option>
                                                    <option value="285">WAHYU ANTON SUJARWO</option>
                                                    <option value="286">ARIF HIDAYATULLAH</option>
                                                    <option value="287">DENI EKA PRASTIAWAN</option>
                                                    <option value="288">DONI ARIFIANTO</option>
                                                    <option value="289">YOGO ADI PRASETYO</option>
                                                    <option value="290">IHWAN RAMADHAN</option>
                                                    <option value="291">RUSKANDIK ARIBOWO</option>
                                                    <option value="292">LESTARI GESANG FITRIANTO</option>
                                                    <option value="293">HARDIAN GALIH PURWANTO</option>
                                                    <option value="294">FATA IRKHAMNA</option>
                                                    <option value="295">ERFAN DANI PRAYOGI</option>
                                                    <option value="296">RISWAN WIDI AKSANA</option>
                                                    <option value="297">IWAN AGUNG SAPUTRO</option>
                                                    <option value="298">SUGENG PURNAMA</option>
                                                    <option value="299">AGUS SALIM</option>
                                                    <option value="300">ANGGA JOHAN PRANATA</option>
                                                    <option value="301">MUHAMMAD NUR FADLI</option>
                                                    <option value="302">MOCHAMAD SHON HAJI</option>
                                                    <option value="303">DIMAS JOKO VALENTINO</option>
                                                    <option value="304">MISBIANTORO</option>
                                                    <option value="305">SUSIANTO</option>
                                                    <option value="306">ARIS KURNIAWAN</option>
                                                    <option value="307">AHMAD NURKHOLIS</option>
                                                    <option value="308">ANANTA BUDI FATONI</option>
                                                    <option value="309">RIVAL ADI JATMIKO</option>
                                                    <option value="310">DADANG ANGGONO</option>
                                                    <option value="311">FAUZAN CHOIRUL ANAM</option>
                                                    <option value="312">ISWANTO</option>
                                                    <option value="313">AHMAD KHOIRUDDIN</option>
                                                    <option value="314">ACHMAD FAISAL ROMADHONI</option>
                                                    <option value="315">OKTAFIYAN BAYU AJI</option>
                                                    <option value="316">DIMAS ARGA SAPUTRA</option>
                                                    <option value="317">CHOIRUL IMAM</option>
                                                    <option value="318">ADAM ARFANI AMIRULLOH</option>
                                                    <option value="319">GADING APRIL YANTO</option>
                                                    <option value="320">ROBIUL LAILATUSH SHOLIHIN</option>
                                                    <option value="321">SERGIO DWI DELLAPANA</option>
                                                    <option value="322">M. ADHA FARIZI</option>
                                                    <option value="323">MARJHY MARATAPATRIA</option>
                                                    <option value="324">JUSEP PRAMUDIANTO</option>
                                                    <option value="325">FITRI ALIANDINI NAKUL</option>
                                                    <option value="326">FERI DWI SANDI</option>
                                                    <option value="327">ACHMAD JAINUL ROFIK </option>
                                                    <option value="328">RESA ARDIANTO</option>
                                                    <option value="329">PWP TEGUH WIYONO NIRWAHARA</option>
                                                    <option value="330">AGUNG WIDIANTO</option>
                                                    <option value="331">ABDUL WAHID</option>
                                                    <option value="332">ADI JAYADI</option>
                                                    <option value="333">ANDRI SWASONO</option>
                                                    <option value="334">BHAYU DIAN CAHYONO</option>
                                                    <option value="335">BUDI HARYANTO</option>
                                                    <option value="336">FADHOR RAHMAN</option>
                                                    <option value="337">HASANUDDIN</option>
                                                    <option value="338">IMAM SUYOKO</option>
                                                    <option value="339">KUSMINARDI</option>
                                                    <option value="340">FIRI IRIANTO</option>
                                                    <option value="341">ARIEF BUDI WINARTA</option>
                                                    <option value="342">YOHANES SIGIT</option>
                                                    <option value="343">FADIL AMRULLOH</option>
                                                    <option value="344">IMAM NURHADI</option>
                                                    <option value="345">SUGENG ASDIANTO</option>
                                                    <option value="346">RYAN PRASETYO</option>
                                                    <option value="347">FEKI FAISAL ANAMTA</option>
                                                    <option value="348">ROSITA LAILA DEWI</option>
                                                    <option value="349">GITO HARI SANTOSO</option>
                                                    <option value="350">IRVAN ASHARI</option>
                                                    <option value="351">MAHMUD FAUZI</option>
                                                    <option value="352">HENDRIK SETIOKO</option>
                                                    <option value="353">NASSER RISKI ROMADHONI</option>
                                                    <option value="354">ERFIN ERLIFIANTO</option>
                                                    <option value="355">RIANTO EFENDI</option>
                                                    <option value="356">ABDHI TUNGGAL</option>
                                                    <option value="357">SUTRISNO</option>
                                                    <option value="358">ERIK SETIO HARMONO</option>
                                                    <option value="359">DODIK ADIANTO</option>
                                                    <option value="360">SUHARTONO DRIVER</option>
                                                    <option value="361">ANDI ISWAHYUDI</option>
                                                    <option value="362">MUHAMMAD SONY</option>
                                                    <option value="363">AYUK WAHYUNI</option>
                                                    <option value="364">KAMUDI</option>
                                                    <option value="365">MAYLINDA CYNTIA D</option>
                                                    <option value="366">SAROFUL ANAM</option>
                                                    <option value="367">TEGUH BARLIAN</option>
                                                    <option value="368">YUVI ISWANTO</option>
                                                    <option value="369">INTAN AYU</option>
                                                    <option value="371">RHENDRHA RAHARDYAN</option>
                                                    <option value="372">M. FU`AT AMIN NUR D</option>
                                                    <option value="373">SYAHRUL MA`RUFI</option>
                                                    <option value="375">KREDIT MP</option>
                                                    <option value="376">ANITA SOEGIHARTO</option>
                                                    <option value="378">ARI HERMAWAN</option>
                                                    <option value="379">DZUL`AFI MUDLOFAR</option>
                                                    <option value="380">ELITA SALLY JEANER ARDEN</option>
                                                    <option value="381">GILANG SAPUTRA P</option>
                                                    <option value="382">HANIFAH</option>
                                                    <option value="383">ISNI APRIYANI</option>
                                                    <option value="384">JOKO PURNOMO</option>
                                                    <option value="385">MEGAWATI</option>
                                                    <option value="386">RATNA SARI</option>
                                                    <option value="387">RIZKI KUSTIAN</option>
                                                    <option value="388">SONNY PRADHANA
                                                    </option>
                                                    <option value="389">TONY AGUS SETIAWAN</option>
                                                    <option value="390">FARIDA-1</option>
                                                    <option value="391">HARIYATI-1</option>
                                                    <option value="392">GI PALAAN</option>
                                                    <option value="393">KLAIM VOUCHER RAT</option>
                                                    <option value="394">WIDIANTO</option>
                                                    <option value="395">RIYAN MULAWARDANA</option>
                                                    <option value="396">ATK GREENFIELDS</option>
                                                    <option value="397">RIWONO</option>
                                                    <option value="398">TANZIIL TAHTA </option>
                                                    <option value="399">MUHAMAD WISNU </option>
                                                    <option value="401">GIGIH TANJUL ARIFIN </option>
                                                    <option value="402">WITONO</option>
                                                    <option value="403">BERNADY HAYKALL</option>
                                                    <option value="404">UDIN - MASJID</option>
                                                    <option value="405">ANGGIK VERDIANTO</option>
                                                    <option value="407">SUPRIADI SATPAM</option>
                                                    <option value="408">BIMO WISMOYO A</option>
                                                    <option value="433">MULYO KUNTONO</option>
                                                    <option value="437">ANGGIA DWI SEVINA</option>
                                                    <option value="462">SONI IRVAN PRATAMA</option>
                                                    <option value="472">MUSRIFIN</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Layanan</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <select id="jenis" onchange="selectJenis()" name="jenis" class="form-control select2" required>
                                                    <option value="Produk">Produk</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">

                                        <div class="form-group barcode-produk">
                                            <input type="hidden" class="form-control" name="idbarangitem" id="idbarangitem" readonly>
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" style="margin-right:9px">Barcode</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="barcode" id="barcode" autofocus autocomplete="off" onkeypress="scanBarcode()">
                                                <span class="input-group-btn">
                                                    <button type="button" onclick="tampildata()" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="kode-servis">
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" name="idservis" id="idservis" readonly>
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="margin-right:9px">Servis</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="kode_servis" id="kode_servis" autofocus autocomplete="off">
                                                    <span class="input-group-btn">
                                                        <button type="button" onclick="tampilservis()" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai</label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <select id="pegawai" name="pegawai" class="form-control select2" required data-placeholder="Pilih Pegawai">
                                                        <option value="0" disabled selected>Pilih Pegawai</option>
                                                        <option value="3">Ciko Ciki Tita</option>
                                                        <option value="16">Rio Febrianto</option>
                                                        <option value="25">Lina Fitriyani</option>
                                                        <option value="26">Dinda Nur Azahra</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Qty</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="number" class="form-control" name="qty" id="qty" autocomplete="off" value="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" class="form-control" name="namaitem" id="namaitem" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Harga</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" class="form-control" name="harga" id="harga" readonly>
                                                <input type="hidden" class="form-control" name="hpp" id="hpp">
                                            </div>
                                        </div>
                                        <div style="text-align: right">
                                            <button type="button" onclick="addItemByClick()" class="btn btn-success btn-sm"><i class="fa fa-shopping-cart m-right-xs"></i> Tambah</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h5><i class="fa fa-folder-open"></i> Produk</h5>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <table id="detilitem" width="100%" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Barcode</th>
                                                    <th>Nama Item</th>
                                                    <th>Harga</th>
                                                    <th>Qty</th>
                                                    <th>Disc / Item</th>
                                                    <th>Total</th>
                                                    <th>Opsi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
		 				<div class="col-md-12 col-sm-12 col-xs-12">
		 					<div class="x_panel">
		 						<div class="x_title">
		 							<h5><i class="fa fa-magic"></i> Service</h5>
		 							<div class="clearfix"></div>
		 						</div>
		 						<div class="x_content">
		 							<table id="detilservis" width="100%" class="table table-striped table-bordered">
		 								<thead>
		 									<tr>
		 										<th>Kode</th>
		 										<th>Nama Servis</th>
		 										<th>Pegawai</th>
		 										<th>Harga</th>
		 										<th>Total</th>
		 										<th>Opsi</th>
		 									</tr>
		 								</thead>
		 							</table>
		 						</div>
		 					</div>
		 				</div>
		 			</div> -->
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                    </div>
                                    <div class="x_content">
                                        <div style="text-align: right" class="pt-3">
                                            <button type="reset" class="btn btn-danger"><i class="fa fa-recycle m-right-xs"></i> Cancel</button>
                                            <button type="button" onclick="simpanPenjualan()" class="btn btn-primary"><i class="fa fa-paper-plane-o m-right-xs"></i> Payment</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal fade" id="showDataModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="showDataModal">Daftar Barang</h4>
                        </div>
                        <div class="modal-body">
                            <table id="daftarbarang" width="100%" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Gambar</th>
                                        <th>Barcode</th>
                                        <th>Nama Item</th>
                                        <th>Satuan</th>
                                        <th>Stok</th>
                                        <th>Harga Jual (Umum)</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                            </table>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="showModalServis">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="showModalServis">Daftar Servis</h4>
                        </div>
                        <div class="modal-body">
                            <table id="daftarservis" width="100%" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Servis</th>
                                        <th>Keterangan</th>
                                        <th>Harga</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                            </table>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editDetilModal">
                <div class="modal-dialog bs-example-modal-sm">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="editDetilModal">Edit Detail Penjualan</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" method="post" action="http://localhost:8080/kopkar/pos/penjualan/editdetiljual">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="hidden" class="form-control has-feedback-left" id="iddetiljual" name="iddetiljual">
                                        <input type="hidden" class="form-control" id="iddetilbarang" name="iddetilbarang">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Barcode</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="editdetilbarcode" id="editdetilbarcode" autocomplete="off" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Item</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="namadetilitem" id="namadetilitem" readonly>
                                    </div>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="hidden" class="form-control" name="hargadetilitem" id="hargadetilitem" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Hpp</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="detilhpp" id="detilhpp" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Qty</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="detilqty" id="detilqty" autocomplete="off">
                                        <input type="hidden" class="form-control" name="hideqty" id="hideqty" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Diskon (Rp)</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="detildiskonitem" id="detildiskonitem" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Total (Rp)</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="detiltotalitem" id="detiltotalitem" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" data-dismiss="modal" onclick="editDetilJual()" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editDetilServisModal">
                <div class="modal-dialog bs-example-modal-sm">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="editDetilServisModal">Edit Detail Penjualan</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" method="post" action="http://localhost:8080/kopkar/pos/penjualan/editdetiljual">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                        <input type="hidden" class="form-control" id="id_detil_jual" name="id_detil_jual">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kode</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="edit_kode_servis" id="edit_kode_servis" autocomplete="off" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Servis</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="nama_detil_servis" id="nama_detil_servis" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Harga Servis</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="harga_detil_servis" id="harga_detil_servis" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <!-- <label class="control-label col-md-3 col-sm-3 col-xs-12">Qty</label> -->
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="hidden" class="form-control" name="detil_qty" id="detil_qty" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Total (Rp)</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="detil_total_servis" id="detil_total_servis" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" data-dismiss="modal" onclick="editServisJual()" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="pembayaranModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="inputKasModal">Pembayaran</h4>
                        </div>
                        <div class="modal-body">
                            <div id="warning" style="text-align:center;width:100%" class=""></div>
                            <form class="form-horizontal" method="post" action="http://localhost:8080/kopkar/pos/penjualan/simpanpenjualan">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="kasir" id="kasir" readonly>
                                    <input type="hidden" class="form-control" name="cus" id="cus" readonly>
                                    <input type="hidden" name="coa_cash" readonly value="11110-000">
                                    <input type="hidden" name="coa_transfer" readonly value="11111-000">
                                    <input type="hidden" name="coa_kredit" readonly value="11210-000">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Total</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="subtotal" id="subtotal" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Diskon (Rp)</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="diskon1" id="diskon1" autocomplete="off" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">PPN</label>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" name="nominal_ppn" id="nominal_ppn" readonly>
                                        <span class="form-control-feedback left" aria-hidden="true"><b>Rp</b></span>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="number" class="form-control" name="ppn_persen" id="ppn_persen" autocomplete="off">
                                        <span class="form-control-feedback right" aria-hidden="true"><b>%</b></span>
                                    </div>
                                </div>
                                <!-- <div class="form-group cek-poin">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">Gunakan Poin</label>
             <div class="col-md-9 col-sm-9 col-xs-12">
               <div class="row">
                 <div class="col-md-2">
                   <label class="text-warning">
                     <input type="checkbox" class="js-switch" id="check" onclick="gunakanPoin()" />
                   </label>
                 </div>
                 <div class="col-md-10">
                   <input type="text" class="form-control" id="poin" name="poin" readonly>
                   <input type="hidden" class="form-control" id="poin1" name="poin1" readonly>
                   <input type="hidden" class="form-control" id="poin2" name="poin2" readonly>
                 </div>
               </div>
             </div>
           </div> -->

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Grand Total</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="grandtotal" id="grandtotal" readonly>
                                        <input type="hidden" class="form-control" name="nominal" id="nominal" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-1 col-md-3 col-sm-3 col-xs-12">Payment Method</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="checkbox">
                                            <label>
                                                <input type="radio" name="metode" id="cash" value="Cash" checked> Cash
                                            </label>
                                            <label>
                                                <input type="radio" name="metode" id="transfer" value="Transfer"> Transfer
                                            </label>
                                            <label>
                                                <input type="radio" name="metode" id="kredit" value="Kredit" disabled> Kredit
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group jatuh-tempo">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jatuh Tempo</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="date" class="form-control" name="tempo" id="tempo" autocomplete="off" value="2023-10-01">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Bayar</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="number" class="form-control" name="bayar" id="bayar" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kembali</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="kembali" id="kembali" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Cetak dan Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function tampildata() {

                    $('#daftarbarang').DataTable({
                        "bProcessing": true,
                        "bJQueryUI": true,
                        "sPaginationType": "full_numbers",
                        "sAjaxSource": 'http://localhost:8080/kopkar/pos/' + 'barang/LoadData',
                        "sAjaxDataProp": "aaData",
                        "fnRender": function(oObj) {
                            uss = oObj.aData["Username"];
                        },
                        "aoColumns": [{
                                "mDataProp": function(data, type, val) {
                                    var gambar = `<img src="http://localhost:8080/kopkar/pos/assets/img/produk/${data.gambar}" class=" mx-auto d-block" width="80px" height="80px" alt="...">`

                                    return (gambar).toString();
                                },

                                bSearchable: true
                            },
                            {
                                "mDataProp": "barcode",
                                bSearchable: true
                            },
                            {
                                "mDataProp": "nama_barang",
                                bSearchable: true
                            },
                            {
                                "mDataProp": "satuan",
                                bSearchable: true
                            },
                            {
                                "mDataProp": "stok",
                                bSearchable: true
                            },
                            {
                                "mDataProp": "harga_jual",
                                bSearchable: true
                            },
                            {
                                "mDataProp": function(data, type, val) {
                                    pKode = data.id_barang;
                                    if (data.stok < 1) {
                                        var btn = '<a href="#" id="pilihitem" class="btn btn-primary btn-xs" data-dismiss="modal" title="Pilih Data" onclick="pilihbarang(' + pKode + ')" disabled><i class="fa fa-check-square-o"></i> Select</a>';
                                    } else {
                                        var btn = '<a href="#" id="pilihitem" class="btn btn-primary btn-xs" data-dismiss="modal" title="Pilih Data" onclick="pilihbarang(' + pKode + ')"><i class="fa fa-check-square-o"></i> Select</a>';
                                    }

                                    return (btn).toString();
                                },
                                bSortable: false,
                                bSearchable: false
                            }
                        ],
                        "bDestroy": true,
                    });

                    $('#showDataModal').modal('show');
                }

                function pilihbarang(e) {
                    var customer = $('#customer').val();
                    $.ajax({
                        url: 'http://localhost:8080/kopkar/pos/' + "barang/detilbarang/" + e,
                        type: "post",
                        success: function(data) {
                            var obj = JSON.parse(data);
                            if (customer == 0) {
                                $('#harga').val(obj.harga_jual);
                                $('#hpp').val(obj.hpp);
                                $('#namaitem').val(obj.nama_barang);
                                $('#idbarangitem').val(obj.id_barang);
                            } else {
                                $.ajax({
                                    url: http: //localhost:8080/kopkar/pos/ + "customer/detilcustomer/" + customer,
                                        type: "post",
                                    success: function(result) {
                                        var res = JSON.parse(result);
                                        if (res.jenis_cs == "Umum") {

                                            $('#harga').val(obj.harga_jual);

                                        } else if (res.jenis_cs == "Toko") {

                                            $('#harga').val(obj.harga_toko);

                                        } else if (res.jenis_cs == "Pelanggan" || res.jenis_cs == "Anggota") {

                                            if (obj.harga_pelanggan == 0) {
                                                $('#harga').val(obj.harga_jual);
                                            } else {
                                                $('#harga').val(obj.harga_pelanggan);
                                            }

                                        } else if (res.jenis_cs == "Sales") {

                                            $('#harga').val(obj.harga_sales);
                                        }
                                        $('#namaitem').val(obj.nama_barang);
                                        $('#idbarangitem').val(obj.id_barang);
                                        $('#hpp').val(obj.hpp);
                                    }
                                })
                            }
                        }
                    })
                }

                function addItemByClick() {
                    SetBolehKredit();
                    var jenis = $('#jenis').val();
                    var harga = $('#harga').val();
                    var pegawai = $('#pegawai').val();
                    var operator = $('#idoperator').val();
                    var hpp = $('#hpp').val();
                    var id, qty, subtotal;
                    if (jenis == "Produk") {
                        qty = $('#qty').val();
                        subtotal = qty * harga;
                        id = $('#idbarangitem').val();
                    } else if (jenis == "Servis") {
                        id = $('#idservis').val();
                        subtotal = harga;
                        qty = 1;
                        if (pegawai == null) {
                            alert('Field Tidak Boleh Kosong!');
                        }
                    }

                    var barcode = document.getElementById('barcode');

                    if (qty == "") {
                        alert('Field Tidak Boleh Kosong!')
                    } else {

                        $.ajax({
                            url: 'http://localhost:8080/kopkar/pos/' + "penjualan/tambahbarang/" + id + '/' + qty + '/' + subtotal + '/' + harga + '/' + jenis + '/' + pegawai + '/' + operator + '/' + hpp,
                            type: "post",
                            success: function(data) {
                                var obj = JSON.parse(data);
                                LoadItemBarang();
                                LoadService();
                                barcode.value = "";
                                barcode.focus();
                                document.getElementById('qty').value = "1";
                                var ppn = obj.subtotal * 11 / 100;
                                var hargaAkhir = Number(obj.subtotal) + ppn;
                                $('#subtot').html(obj.subtotal);
                                $('#subtotal').val(obj.subtotal);
                                $('#grandtotal').val(obj.subtotal);
                                // $('#nominal_ppn').val(ppn);
                                $('#nominal').val(obj.subtotal);
                            }
                        });
                    }
                }

                function addItemByScan() {
                    var id = $('#idbarangitem').val();
                    pilihbarang(id);
                    SetBolehKredit();
                    var customer = $('#customer').val();
                    var pegawai = null;
                    var jenis = "Produk";
                    var qty = 1;
                    var harga = $('#harga').val();
                    var subtotal = qty * harga;
                    var operator = $('#idoperator').val();

                    var hpp = $('#hpp').val();
                    var barcode = document.getElementById('barcode');
                    $.ajax({
                        url: 'http://localhost:8080/kopkar/pos/' + "penjualan/tambahbarangbyscan/" + id + '/' + qty + '/' + subtotal + '/' + harga + '/' + jenis + '/' + pegawai + '/' + operator + '/' + customer,
                        type: "post",
                        success: function(data) {
                            var obj = JSON.parse(data);
                            LoadItemBarang();
                            barcode.value = "";
                            barcode.focus();
                            document.getElementById('qty').value = "";
                            var ppn = obj.subtotal * 11 / 100;
                            var hargaAkhir = ppn + Number(obj.subtotal);
                            $('#subtot').html(obj.subtotal);
                            $('#subtotal').val(obj.subtotal);
                            $('#grandtotal').val(obj.subtotal);
                            // $('#nominal_ppn').val(ppn);
                            $('#nominal').val(obj.subtotal);
                        }
                    });
                }

                function LoadItemBarang() {
                    $('#detilitem').DataTable({
                        "bProcessing": true,
                        "bJQueryUI": true,
                        "sPaginationType": "full_numbers",
                        "sAjaxSource": 'http://localhost:8080/kopkar/pos/' + 'penjualan/LoadData',
                        "sAjaxDataProp": "aaData",
                        "fnRender": function(oObj) {
                            uss = oObj.aData["Username"];
                        },
                        "aoColumns": [{
                                "mDataProp": "barcode",
                                bSearchable: true
                            },
                            {
                                "mDataProp": "nama_barang",
                                bSearchable: true
                            },
                            {
                                "mDataProp": "harga_jual",
                                bSearchable: true
                            },
                            {
                                "mDataProp": "qty_jual",
                                bSearchable: true
                            },
                            {
                                "mDataProp": "diskon",
                                bSearchable: true
                            },
                            {
                                "mDataProp": "subtotal",
                                bSearchable: true
                            },
                            {
                                "mDataProp": function(data, type, val) {
                                    pKode = data.id_detil_jual;
                                    var btn = '<a href="#" class="btn btn-primary btn-xs" title="Edit Data" onclick="editDetilItem(' + pKode + ')"><i class="fa fa-edit"></i></a> \n\ <a href="#" class="btn btn-danger btn-xs" title="Hapus Data" onclick="hapusDetilItem(' + pKode + ')"><i class="fa fa-trash "></i></a>';

                                    return (btn).toString();
                                },
                                bSortable: false,
                                bSearchable: false
                            }
                        ],
                        "bDestroy": true,
                    });
                }

                function LoadService() {
                    $('#detilservis').DataTable({
                        "bProcessing": true,
                        "bJQueryUI": true,
                        "sPaginationType": "full_numbers",
                        "sAjaxSource": 'http://localhost:8080/kopkar/pos/' + 'penjualan/LoadDataService',
                        "sAjaxDataProp": "aaData",
                        "fnRender": function(oObj) {
                            uss = oObj.aData["Username"];
                        },
                        "aoColumns": [{
                                "mDataProp": "kode",
                                bSearchable: true
                            },
                            {
                                "mDataProp": "nama_servis",
                                bSearchable: true
                            },
                            {
                                "mDataProp": "nama_karyawan",
                                bSearchable: true
                            },
                            {
                                "mDataProp": "harga_item",
                                bSearchable: true
                            },
                            {
                                "mDataProp": "subtotal",
                                bSearchable: true
                            },
                            {
                                "mDataProp": function(data, type, val) {
                                    pKode = data.id_detil_jual;
                                    var btn = '<a href="#" class="btn btn-primary btn-xs" title="Edit Data" onclick="editDetilServis(' + pKode + ')"><i class="fa fa-edit"></i></a> \n\ <a href="#" class="btn btn-danger btn-xs" title="Hapus Data" onclick="hapusDetilService(' + pKode + ')"><i class="fa fa-trash "></i></a>';

                                    return (btn).toString();
                                },
                                bSortable: false,
                                bSearchable: false
                            }
                        ],
                        "bDestroy": true,
                    });
                }

                function OnLoadForm() {
                    LoadItemBarang();
                    LoadService();
                }

                function editDetilServis(e) {
                    var qty = $('#detilqty');
                    var diskon = $('#detildiskonitem');
                    var subtotal = $('#detiltotalitem');
                    $.ajax({
                        url: 'http://localhost:8080/kopkar/pos/' + "penjualan/detilservisjual/" + e,
                        type: "post",
                        success: function(data) {
                            var obj = JSON.parse(data);
                            $('#id_detil_jual').val(obj.id_detil_jual);
                            $('#edit_kode_servis').val(obj.kode);
                            $('#nama_detil_servis').val(obj.nama_servis);
                            $('#harga_detil_servis').val(obj.harga_item);
                            $('#detil_qty').val(obj.qty_jual);
                            $('#detil_total_servis').val(obj.subtotal);

                        }
                    });
                    $('#editDetilServisModal').modal('show');
                }

                function editDetilItem(e) {
                    var qty = $('#detilqty');
                    var diskon = $('#detildiskonitem');
                    var subtotal = $('#detiltotalitem');
                    $.ajax({
                        url: 'http://localhost:8080/kopkar/pos/' + "penjualan/detilitemjual/" + e,
                        type: "post",
                        success: function(data) {
                            var obj = JSON.parse(data);
                            $('#iddetiljual').val(obj.id_detil_jual);
                            $('#iddetilbarang').val(obj.id_barang);
                            $('#editdetilbarcode').val(obj.barcode);
                            $('#namadetilitem').val(obj.nama_barang);
                            $('#hargadetilitem').val(obj.harga_jual);
                            $('#detilqty').val(obj.qty_jual);
                            $('#hideqty').val(obj.qty_jual);
                            $('#detildiskonitem').val(obj.diskon);
                            $('#detiltotalitem').val(obj.subtotal);
                            $('#detilhpp').val(obj.hpp);
                        }
                    });
                    $('#editDetilModal').modal('show');
                }

                function hapusDetilItem(e) {
                    Swal.fire({
                        title: "Are you sure ?",
                        text: "Deleted data can not be restored!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: 'http://localhost:8080/kopkar/pos/' + "penjualan/hapusdetil/" + e,
                                type: "post",
                                success: function(data) {
                                    LoadItemBarang();
                                    SetBolehKredit();
                                    var obj = JSON.parse(data);
                                    var ppn = obj.subtotal * 10 / 100;
                                    var hargaAkhir = ppn + Number(obj.subtotal);
                                    if (obj.subtotal != null) {
                                        $('#subtot').text(obj.subtotal);
                                    } else {
                                        $('#subtot').text(0);
                                    }
                                }
                            })
                        }
                    })
                }

                function hapusDetilService(e) {
                    Swal.fire({
                        title: "Are you sure ?",
                        text: "Deleted data can not be restored!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: 'http://localhost:8080/kopkar/pos/' + "penjualan/hapusdetil/" + e,
                                type: "post",
                                success: function(data) {
                                    LoadService();
                                    var obj = JSON.parse(data);
                                    var ppn = obj.subtotal * 10 / 100;
                                    var hargaAkhir = ppn + Number(obj.subtotal);
                                    if (obj.subtotal != null) {
                                        $('#subtot').text(obj.subtotal);
                                    } else {
                                        $('#subtot').text(0);
                                    }
                                }
                            })
                        }
                    })
                }

                function editDetilJual() {
                    var id = $('#iddetiljual').val();
                    var qty = $('#detilqty').val();
                    var qty1 = $('#hideqty').val();
                    var diskon = $('#detildiskonitem').val();
                    var subtotal = $('#detiltotalitem').val();
                    var idBrg = $('#iddetilbarang').val();
                    var hpp = $('#detilhpp').val();
                    $.ajax({
                        url: 'http://localhost:8080/kopkar/pos/' + "penjualan/editdetiljual/" + id + '/' + diskon + '/' + qty + '/' + subtotal + '/' + hpp,
                        type: "post",
                        success: function(data) {
                            var stok = qty1 - qty;
                            updateStok(stok, idBrg);
                            LoadItemBarang();
                            $.ajax({
                                url: 'http://localhost:8080/kopkar/pos/' + "penjualan/hargatotal",
                                type: "post",
                                success: function(data) {
                                    var obj = JSON.parse(data);
                                    var ppn = obj.subtotal * 10 / 100;
                                    var hargaAkhir = ppn + Number(obj.subtotal);
                                    $('#subtot').html(obj.subtotal);
                                    $('#subtotal').val(obj.subtotal);
                                    $('#grandtotal').val(obj.subtotal);
                                    $('#diskon1').val(obj.diskon);
                                    SetBolehKredit();
                                }
                            });
                        }
                    });
                }

                function editServisJual() {
                    const id = $('#id_detil_jual').val();
                    const qty = $('#detil_qty').val();
                    const harga = $('#harga_detil_servis').val();
                    const subtotal = $('#detil_total_servis').val();
                    $.ajax({
                        url: 'http://localhost:8080/kopkar/pos/' + "penjualan/editservisjual/" + id + '/' + harga + '/' + subtotal,
                        type: "post",
                        success: function(data) {
                            LoadService();
                            $.ajax({
                                url: 'http://localhost:8080/kopkar/pos/' + "penjualan/hargatotal",
                                type: "post",
                                success: function(data) {
                                    var obj = JSON.parse(data);
                                    // var ppn = obj.subtotal * 10 / 100;
                                    // var hargaAkhir = ppn + Number(obj.subtotal);
                                    $('#subtot').html(obj.subtotal);
                                    $('#subtotal').val(obj.subtotal);
                                    $('#grandtotal').val(obj.subtotal);
                                    $('#diskon1').val(obj.diskon);

                                }
                            });
                        }
                    });
                }

                function updateStok(stok, id) {
                    $.ajax({
                        url: 'http://localhost:8080/kopkar/pos/' + "barang/updateStok/" + stok + '/' + id,
                        type: "post",
                        success: function(data) {

                        }
                    });
                }

                function simpanPenjualan() {
                    SetBolehKredit();
                    var cs = $('#customer').val();
                    var user = $('#idoperator').val();
                    $('#cus').val(cs);
                    $('#kasir').val(user);
                    $.ajax({
                        url: 'http://localhost:8080/kopkar/pos/' + "penjualan/hargatotal",
                        type: "post",
                        success: function(data) {
                            var obj = JSON.parse(data);
                            var ppn = obj.subtotal * 10 / 100;
                            var hargaAkhir = ppn + Number(obj.subtotal);
                            const ck = document.getElementById('cash');
                            $('#diskon1').val(obj.diskon);
                            $('#subtot').html(obj.subtotal);
                            $('#subtotal').val(obj.subtotal);
                            $('#grandtotal').val(obj.subtotal);
                            // $('#nominal_ppn').val(ppn);
                            $('#nominal').val(obj.subtotal);
                            ck.checked = true;
                            //console.log(ck);
                        }
                    });
                    $('#pembayaranModal').modal('show');
                }

                function editPenjualan() {
                    $('#editPembayaranModal').modal('show');
                }

                function detilJual(e) {
                    $('#detilPenjualanModal').modal('show');
                }

                function scanBarcode() {
                    var key = $('#barcode');
                    var customer = $('#customer').val();
                    $.ajax({
                        url: 'http://localhost:8080/kopkar/pos/' + "barang/caribarang/" + key.val(),
                        type: "post",
                        success: function(data) {
                            var obj = JSON.parse(data);
                            if (customer == 0) {
                                $('#harga').val(obj.harga_jual);
                                $('#namaitem').val(obj.nama_barang);
                                $('#idbarangitem').val(obj.id_barang);
                                $('#kodebrg').val(obj.kode_barang);
                                addItemByScan();
                            } else {
                                $.ajax({
                                    url: site_url() + "customer/detilcustomer/" + customer,
                                    type: "post",
                                    success: function(result) {
                                        var res = JSON.parse(result);
                                        if (res.jenis_cs == "Umum") {

                                            $('#harga').val(obj.harga_jual);

                                        } else if (res.jenis_cs == "Toko") {

                                            $('#harga').val(obj.harga_toko);

                                        } else if (res.jenis_cs == "Pelanggan") {

                                            $('#harga').val(obj.harga_pelanggan);

                                        } else if (res.jenis_cs == "Sales") {

                                            $('#harga').val(obj.harga_sales);
                                        }
                                        $('#namaitem').val(obj.nama_barang);
                                        $('#idbarangitem').val(obj.id_barang);
                                        $('#kodebrg').val(obj.kode_barang);
                                        addItemByScan();
                                    }
                                })
                            }
                        }
                    })
                }

                function selectJenis() {
                    let jenis = $('#jenis').val();
                    if (jenis == "Servis") {
                        $('.barcode-produk').hide();
                        $('.kode-servis').show();
                        $('#qty').attr('disabled', 'disabled');
                    } else if (jenis == "Produk") {
                        $('.barcode-produk').show();
                        $('.kode-servis').hide();
                        $('#qty').removeAttr('disabled');
                    }
                }

                function tampilservis() {
                    $('#daftarservis').DataTable({
                        "bProcessing": true,
                        "bJQueryUI": true,
                        "sPaginationType": "full_numbers",
                        "sAjaxSource": 'http://localhost:8080/kopkar/pos/' + 'servis/LoadData',
                        "sAjaxDataProp": "aaData",
                        "fnRender": function(oObj) {
                            uss = oObj.aData["Username"];
                        },
                        "aoColumns": [{
                                "mDataProp": "kode",
                                bSearchable: true
                            },
                            {
                                "mDataProp": "nama_servis",
                                bSearchable: true
                            },
                            {
                                "mDataProp": "keterangan",
                                bSearchable: true
                            },
                            {
                                "mDataProp": "harga",
                                bSearchable: true
                            },
                            {
                                "mDataProp": function(data, type, val) {
                                    pKode = data.id_servis;

                                    var btn = '<a href="#" id="pilihservis" class="btn btn-primary btn-xs" data-dismiss="modal" title="Pilih Data" onclick="pilihservis(' + pKode + ')"><i class="fa fa-check-square-o"></i> Select</a>';

                                    return (btn).toString();
                                },
                                bSortable: false,
                                bSearchable: false
                            }
                        ],
                        "bDestroy": true,
                    });

                    $('#showModalServis').modal('show');
                }

                function pilihservis(e) {
                    $.ajax({
                        url: 'http://localhost:8080/kopkar/pos/' + "servis/detail/" + e,
                        type: "post",
                        success: function(data) {
                            var obj = JSON.parse(data);
                            $('#harga').val(obj.harga);
                            $('#namaitem').val(obj.nama_servis);
                            $('#idservis').val(obj.id_servis);
                        }
                    })
                }

                function SetBolehKredit() {
                    cust = document.getElementById('customer');
                    kr = document.getElementById('kredit');
                    warning = document.getElementById('warning');


                    const rupiah = (number) => {
                        return new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR"
                        }).format(number);
                    }

                    idcust = cust.options[cust.selectedIndex].value;
                    if (idcust == 0) {
                        console.log(cust.options[cust.selectedIndex].value);
                        kr.disabled = true;
                        warning.classList.remove("alert");
                    } else {
                        kr.disabled = false;
                        $.ajax({
                            url: 'http://localhost:8080/kopkar/pos/' + "penjualan/cek_piutang/" + idcust,
                            type: "post",
                            success: function(data) {
                                var obj = JSON.parse(data);
                                var tot = Number(obj.total) + Number(obj.belanja);
                                warning.innerHTML = rupiah(tot);
                                if (tot > 82500000) {
                                    warning.classList.add("alert");
                                    warning.classList.add("alert-danger");
                                    warning.innerHTML = "Total belanja atau piutang telah melebihi batas, pembelian secara kredit tidak diijinkan. total : " + rupiah(tot);
                                    kr.disabled = true;
                                } else {
                                    if (tot > 750000) {
                                        warning.classList.add("alert");
                                        warning.classList.add("alert-warning");
                                        warning.innerHTML = "Total piutang plus belanja hari ini telah mencapai " + rupiah(tot);
                                    } else {
                                        warning.classList.remove("alert")
                                        warning.innerHTML = "";
                                    }
                                }
                            }
                        });
                    }

                }
            </script>
            <footer>
                <div class="pull-right">
                    Copyright &copy; Point Of Sales 2023 by Pillar Sejahtera
                </div>
                <div class="clearfix"></div>
            </footer>
        </div>
    </div>
    <script src="http://localhost:8080/kopkar/pos/assets/vendors/jquery/dist/jquery.min.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/vendors/fastclick/lib/fastclick.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/vendors/nprogress/nprogress.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/vendors/Chart.js/dist/Chart.min.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/vendors/DateJS/build/date.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/vendors/moment/min/moment.min.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/build/js/custom.min.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <!-- <script src="select2/dist/js/select2.full.min.js"></script> -->
    <script type="text/javascript" src="http://localhost:8080/kopkar/pos/assets/DataTables/datatables.min.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/grafik/chart.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/Javascript/Js-main.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/Javascript/modjs-custom.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/select2/select2.min.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/vendors/switchery/dist/switchery.min.js"></script>
    <!----------------------------------------------old data table------------------------------------------------>
    <script src="http://localhost:8080/kopkar/pos/assets/old-data-tables/bootstrap-table.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/old-data-tables/tableExport.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/old-data-tables/data-table-active.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/old-data-tables/bootstrap-table-editable.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/old-data-tables/bootstrap-editable.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/old-data-tables/bootstrap-table-resizable.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/old-data-tables/colResizable-1.5.source.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/old-data-tables/bootstrap-table-export.js"></script>
    <!--  editable JS
				============================================ -->
    <script src="http://localhost:8080/kopkar/pos/assets/editable/jquery.mockjax.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/editable/mock-active.js"></script>

    <script src="http://localhost:8080/kopkar/pos/assets/editable/moment.min.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/editable/bootstrap-datetimepicker.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/editable/bootstrap-editable.js"></script>
    <script src="http://localhost:8080/kopkar/pos/assets/editable/xediable-active.js"></script>
    <!---------------------------------------------end old data table---------------------------------------------->

    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('.datatable').DataTable();
            $('.kode-servis').hide();
            $('.jatuh-tempo').hide();
            var persen_ppn = $('#ppn_persen');
            var subtotal = $('#subtotal');
            var grandtotal = $('#grandtotal');
            var ppn_rp = $('#nominal_ppn');
            persen_ppn.keyup(function() {
                var persen = document.getElementById('ppn_persen').value;
                if (persen == null || persen == 0) {
                    grandtotal.val(subtotal.val());
                    ppn_rp.val(0);
                } else {
                    var nominal_ppn = subtotal.val() * persen_ppn.val() / 100;
                    ppn_rp.val(nominal_ppn);
                    var total = Number(subtotal.val()) + Number(nominal_ppn);
                    grandtotal.val(total);

                }
            });

            $('input:radio[name="metode"]').on('change', function() {
                var pay = document.getElementById("bayar");
                var kembali = document.getElementById("kembali");
                var total = document.getElementById("grandtotal");
                if ($(this).is(':checked') && $(this).val() == "Cash") {
                    $('.jatuh-tempo').hide();
                    kembali.value = "";
                    pay.removeAttribute("readonly");
                } else if ($(this).is(':checked') && $(this).val() == "Kredit") {
                    $('.jatuh-tempo').show();
                    pay.value = 0; // memberikan nilai pada elemen input
                    pay.setAttribute("readonly", "readonly");
                    kembali.value = (-1 * total.value);
                } else {
                    $('.jatuh-tempo').hide();
                    pay.removeAttribute("readonly");
                    kembali.value = "";
                }
            });

            hitung_servis();
            diskon();
            totalbayar();
            invoice();
            discbeli();
            $('#ppn_persen').val(0);
            $('#nominal_ppn').val(0);
            $('#diskon1').val(0);
            $('#diskonbeli').val(0);
            $('#selisih').val(0);
            grafikKategori();
            grafikKas();
            grafikPendapatan();
            grafikTerlaris();
        })
        var table = $('#example').DataTable();

        $('#example').on('page.dt', function() {
            var page = table.page.info();
            for (let i = page.start; i < page.end; i++) {
                var kode = table.cell(i, 3).data();
                var coa = table.cell(i, 2).data();
                $.ajax({
                    url: "http://localhost:8080/kopkar/pos/Posting/CekPosting",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: kode,
                        coa: coa,
                    },
                    success: function(data) {
                        //memasukkan data shift ke dalam form
                        if (data.id == '') {
                            table.cell(i, 7).data("<div id='" + kode + "'><i class='fa fa-times' style='color:red'></i></div>");
                        } else {
                            table.cell(i, 7).data("<div id='" + kode + "'><i class='fa fa-check' style='color:green'></i></div>");
                        }
                    },
                });

            }


        });

        table.on('search.dt', function() {
            var row = table.rows({
                search: 'applied'
            });
            var jml = table.rows({
                search: 'applied'
            }).count();
            console.log('halaman : ', jml);
            for (let i = 0; i < jml; i++) {
                var kode = table.cell(row[0][i], 3).data();
                var coa = table.cell(row[0][i], 2).data();
                if (i <= table.page.len()) {
                    $.ajax({
                        url: "http://localhost:8080/kopkar/pos/Posting/CekPosting",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id: kode,
                            coa: coa,
                        },
                        success: function(data) {
                            //memasukkan data shift ke dalam form
                            if (data.id == '') {
                                table.cell(row[0][i], 7).data("<div id='" + kode + "'><i class='fa fa-times' style='color:red'></i></div>");
                            } else {
                                table.cell(row[0][i], 7).data("<div id='" + kode + "'><i class='fa fa-check' style='color:green'></i></div>");
                            }
                        },
                    });
                } else {
                    break;
                }
            }

        });

        table.on('click', 'button', function(e) {
            let data = table.row(e.target.closest('tr')).data();
            $.ajax({
                url: "http://localhost:8080/kopkar/pos/Posting/Repost",
                type: 'POST',
                dataType: 'json',
                data: {
                    tgl: data[1],
                    coa: data[2],
                    id: data[3],
                    ket: data[4],
                    debet: data[5],
                    kredit: data[6],
                },
                success: function(res) {
                    //memasukkan data shift ke dalam form
                    if (res.id > 0) {
                        let page = table.page.info();
                        for (let i = page.start; i < page.end; i++) {
                            var kode = table.cell(i, 3).data();
                            var coa = table.cell(i, 2).data();
                            $.ajax({
                                url: "http://localhost:8080/kopkar/pos/Posting/CekPosting",
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    id: kode,
                                    coa: coa,
                                },
                                success: function(data) {
                                    //memasukkan data shift ke dalam form
                                    if (data.id == '') {
                                        table.cell(i, 7).data("<div id='" + kode + "'><i class='fa fa-times' style='color:red'></i></div>");
                                    } else {
                                        table.cell(i, 7).data("<div id='" + kode + "'><i class='fa fa-check' style='color:green'></i></div>");
                                    }
                                },
                            });

                        }
                    }
                },
            });
        });

        const timer = ms => new Promise(res => setTimeout(res, ms))
        async function test() { // We need to wrap the loop into an async function for this to work
            var jml = table.rows().count();
            for (var i = 0; i < jml; i++) {
                console.log(i);
                await timer(500); // then the created Promise can be awaited
            }
        }
    </script>
</body>

</html>