<div x-data="setup()" x-init="$refs.loading.classList.add('hidden');">
    <!-- Loading screen -->
    <div x-ref="loading"
        class="fixed inset-0 z-50 flex items-center justify-center text-2xl font-semibold text-white bg-yellow-600">

        Loading.....
    </div>

    <!-- Sidebar -->
    <div x-transition:enter="transform transition-transform duration-300" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transform transition-transform duration-300"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-show="isSidebarOpen"
        class="fixed inset-y-0 z-10 flex w-80">
        <!-- Curvy shape -->
        <svg class="absolute inset-0 w-full h-full text-white" style="filter: drop-shadow(10px 0 10px #00000060)"
            preserveAspectRatio="none" viewBox="0 0 309 700" fill="currentColor">
            <path
                d="M268.487 0H0V800H247.32C207.957 725 207.975 492.294 268.487 367.647C329 243 314.906 53.4314 268.487 0Z" />
        </svg>
        <!-- Sidebar content -->
        <div class="z-10 flex flex-col flex-10">
            <div class="flex items-center justify-between flex-shrink-0 w-64 p-4">
                <!-- Logo -->
                <a href="/dashboard">
                    <div class="flex items-center mt-3">
                        <img src="../../pic/losum.png" alt="logoSumbar" class="h-10 mt-3 w-9">
                        <span class="mt-2 ml-4 font-serif text-lg font-bold text-black">S I P P A K</span>
                    </div>
                </a>
                <!-- Close btn -->
                <button @click="isSidebarOpen = false" class="p-4 mt-3 rounded-lg w-7 focus:outline-none">
                    <svg class="w-6 h-6 mt-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="sr-only">Close sidebar</span>
                </button>
            </div>
            <div class="flex flex-col min-h-screen">
                <div class="w-4/5 mx-auto mt-2 text-sm font-semibold text-left text-black show">
                    <a class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-slate-400 text-black"
                        style="margin-left: -20px" href="/dashboard">
                        <img src="../../pic/Dashboard.png" alt="KGB Icon" class="w-6 h-6">
                        <span class="text-[18px] ml-4 text-black font-bold font-serif">DASHBOARD</span>
                    </a>

                    @if (Gate::any(['operator', 'jft', 'kabag', 'kabiro']))

                        <a class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-slate-400 text-black"
                            style="margin-left: -20px" href="/kgb">
                            <img src="../../pic/Gaji.png" alt="KGB Icon" class="w-6 h-6">

                            <span class="text-[18px] ml-4 text-black font-bold font-serif">KGB</span>
                        </a>
                    @endcan


                    @if (Gate::any(['operator', 'jft', 'kabag', 'kabiro']))
                        <a class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-slate-400 text-black"
                            style="margin-left: -20px" href="/cuti">
                            <img src="../../pic/off.png" alt="KGB Icon" class="w-6 h-6">
                            <span class="text-[18px] ml-4 text-black font-bold font-serif">CUTI</span>
                        </a>
                    @endif

                    @if (!Gate::any(['operator', 'jft', 'kabag', 'kabiro', 'admin']))
                        <a class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-slate-400 text-black"
                            style="margin-left: -20px" href="/naikpangkat">
                            <img src="../../pic/Naik Pangkat.png" alt="KGB Icon" class="w-6 h-6">

                            <span class="text-[18px] ml-4 text-black font-bold font-serif">NAIK PANGKAT</span>
                        </a>
                    @endif

                    @if (Gate::any(['operator', 'jft', 'kabag', 'kabiro']))
                        <a class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-slate-400 text-black w-72"
                            style="margin-left: -20px" href="/pengantar">
                            <img src="../../pic/surat.png" alt="KGB Icon" class="w-6 h-6">

                            <span class="text-[18px] ml-4 text-black font-bold font-serif">SURAT PENGANTAR</span>
                        </a>
                    @endif

                    @can('operator')
                        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-slate-400 text-black w-60"
                            onclick="dropdown()" style="margin-left: -20px">
                            <img src="../../pic/rekap.png" alt="KGB Icon" class="w-6 h-6">
                            <div class="flex items-center justify-between w-full">
                                <span class="text-[18px] ml-4 text-black font-bold font-serif">REKAPITULASI</span>
                                <span class="text-sm rotate-180" id="arrow">
                                    <i class="p-2 bi bi-chevron-down"></i>
                                </span>
                            </div>
                        </div>
                        <div class="w-4/5 mx-auto mt-2 text-sm font-bold text-left text-gray-200" id="submenu">
                            <a href="/rekapKGB"
                                class="flex items-center w-40 px-4 mt-3 text-black duration-300 rounded-md cursor-pointer hover:bg-slate-300"
                                style="margin-left: -20px" href="/bezzetting">
                                <img src="../../pic/Gaji.png" alt="KGB Icon" class="w-5 h-5">
                                <span class="text-[12px] ml-4 text-black font-bold font-serif">KGB</span>
                            </a>
                            <a href="/rekapCuti"
                                class="flex items-center w-40 px-4 mt-3 text-black duration-300 rounded-md cursor-pointer hover:bg-slate-300"
                                style="margin-left: -20px" href="/rekapCuti">
                                <img src="../../pic/off.png" alt="KGB Icon" class="w-5 h-5">
                                <span class="text-[12px] ml-4 text-black font-bold font-serif">Cuti</span>
                            </a>
                            <a href="/RekapNaikPangkat"
                                class="flex items-center w-40 px-4 mt-3 text-black duration-300 rounded-md cursor-pointer hover:bg-slate-300"
                                style="margin-left: -20px" href="#">
                                <img src="../../pic/Naik Pangkat.png" alt="KGB Icon" class="w-5 h-5">
                                <span class="text-[12px] ml-4 text-black font-bold font-serif">Naik Pangkat</span>
                            </a>
                            <a href="/duk"
                                class="flex items-center w-40 px-4 mt-3 text-black duration-300 rounded-md cursor-pointer hover:bg-slate-300"
                                style="margin-left: -20px" href="/duk">
                                <img src="../../pic/DUK.png" alt="KGB Icon" class="w-5 h-5">
                                <span class="text-[12px] ml-4 text-black font-bold font-serif">DUK</span>
                            </a>
                            <a href="/bezzetting"
                                class="flex items-center w-40 px-4 mt-3 text-black duration-300 rounded-md cursor-pointer hover:bg-slate-300"
                                style="margin-left: -20px">
                                <img src="../../pic/Bz.png" alt="KGB Icon" class="w-5 h-5">
                                <span class="text-[12px] ml-4 text-black font-bold font-serif">BEZZETTING</span>
                            </a>
                            <a href="/RekapPensiun"
                                class="flex items-center w-40 px-4 mt-3 text-black duration-300 rounded-md cursor-pointer hover:bg-slate-300"
                                style="margin-left: -20px" href="/">
                                <img src="../../pic/document.png" alt="KGB Icon" class="w-5 h-5">
                                <span class="text-[12px] ml-4 text-black font-bold font-serif">Pensiun</span>
                            </a>
                        </div>
                    @endcan

                    @can('admin')
                        <a href="/userset"
                            class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-slate-400 w-56 text-black"
                            style="margin-left: -20px" style="/#">
                            <img src="../../pic/sett.png" alt="KGB Icon" class="w-6 h-6">
                            <span class="text-[18px] ml-4 text-black font-bold font-serif">USER SETTING</span>
                        </a>
                        <a href="/history"
                            class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-slate-400 w-52 text-black"
                            style="margin-left: -20px" style="/#">
                            <img src="../../pic/hist.png" alt="KGB Icon" class="w-6 h-6">
                            <span class="text-[18px] ml-4 text-black font-bold font-serif">HISTORY</span>
                        </a>
                    @endcan


                    @can('kabiro')
                        <a href="/kabiro"
                            class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-slate-400 w-56 text-black"
                            style="margin-left: -20px">
                            <img src="../../pic/sett.png" alt="KGB Icon" class="w-6 h-6">
                            <span class="text-[18px] ml-4 text-black font-bold font-serif">KABIRO</span>
                        </a>
                    @endcan

                    <a class=" mt-80 p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-red-600 text-black w-48 absolute bottom-2"
                        style="margin-left: -20px;" href="/logout">
                        <img src="../../pic/LO.png" alt="Logout Icon"class="w-6 h-6">
                        <span class="text-[20px] ml-4 text-black font-bold font-serif">LOGOUT</span>
                    </a>
            </div>
        </div>
    </div>
</div>
<main class="flex flex-col items-center justify-center flex-1">
    <!-- Page content -->
    <button @click="isSidebarOpen = true"
        class="z-[2] fixed p-1 text-black rounded-lg mt-[-37px] bg-slate-50 top-11 left-40  hover:bg-blue-200">
        <img src="../../pic/menu.png" alt="Gambar SVG" class="w-6 h-6">
        <span class="z[2] p-10 sr-only">Open menu</span>
    </button>
    <h1 class="sr-only">Home</h1>

    <path fill-rule="evenodd" clip-rule="evenodd"
        d="M7.69141 34.7031L13.9492 28.1992L32.0898 52H40.1758L18.4492 23.418L38.5938 0.8125H30.4375L7.69141 26.125V0.8125H0.941406V52H7.69141V34.7031ZM35.3008 26.9102H52.457V21.6016H35.3008V26.9102ZM89.1914 13V35.5117C89.1914 39.2148 88.1719 42.0859 86.1328 44.125C84.1172 46.1641 81.1992 47.1836 77.3789 47.1836C73.6055 47.1836 70.6992 46.1641 68.6602 44.125C66.6211 42.0625 65.6016 39.1797 65.6016 35.4766V0.8125H58.9219V35.6875C58.9688 40.9844 60.6562 45.1445 63.9844 48.168C67.3125 51.1914 71.7773 52.7031 77.3789 52.7031L79.1719 52.6328C84.3281 52.2578 88.4062 50.5352 91.4062 47.4648C94.4297 44.3945 95.9531 40.4453 95.9766 35.6172V13H89.1914ZM89 8H96V1H89V8Z" />
    </svg>
    </a>
</main>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.1/alpine.js"></script>
<script>
    const setup = () => {
        return {
            isSidebarOpen: false,
        }
    }
</script>

<script type="text/javascript">
    function dropdown() {
        document.querySelector("#submenu").classList.toggle("hidden");
        document.querySelector("#arrow").classList.toggle("rotate-180");
    }
    dropdown();

    function openSidebar() {
        document.querySelector(".sidebar").classList.toggle("hidden");
    }
</script>




{{-- <div class="flex items-center p-2 px-4 mt-3 text-black duration-300 rounded-md cursor-pointer hover:bg-blue-600 w-60"
    style="margin-left: -20px">
    <img src="pic/Bz.png" alt="KGB Icon" class="w-6 h-6">
    <span class="text-[20px] ml-4 text-black font-bold">KEPEGAWAIAN</span>
    <span class="w-10 text-sm rotate-180" id="arrow">
        <i class="bi bi-chevron-down" class="w-10"></i>
    </span>
</div> --}}



{{-- template --}}
{{-- <details close style="margin-left: -20px ">
    <summary
    class="flex items-center p-2 px-4 mt-3 text-black duration-300 rounded-md cursor-pointer hover:bg-blue-600 w-60">
    <img src="pic/Bz.png" alt="KGB Icon" class="w-6 h-6">
    <span class="text-[20px] ml-4 text-black font-bold">KEPEGAWAIAN</span>
    <span class="w-10 text-sm rotate-180" id="arrow">
        <i class="bi bi-chevron-down" class="w-10"></i>
    </span>
</summary>
<ul>
            <li
                class="flex items-center p-2 px-4 mt-3 text-black duration-300 rounded-md cursor-pointer hover:bg-blue-600 w-60">
                <span class="text-[12px] ml-4 text-black font-bold">SUB MENU 1</span>
            </li>
            <li
                class="flex items-center p-2 px-4 mt-3 text-black duration-300 rounded-md cursor-pointer hover:bg-blue-600 w-60">
                <span class="text-[12px] ml-4 text-black font-bold">SUB MENU 2</span>
            </li>
        </ul>
    </details> --}}
