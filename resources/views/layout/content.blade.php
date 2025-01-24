<div class="flex flex-col min-h-screen">
    <!-- Bagian konten utama -->
    <div class="flex-grow">
        <div class="p-2"></div>
        <div class="w-full">
            <div class="navigasi flex-none w-14 transition-all duration-150 inline-block bg-black h-full"></div>
            <div class="inline-block flex-auto w-full h-full">
                @yield('isi')
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer footer-center p-4" style="bottom: 0; left:0;">
        <aside>
            <p class="font-bold">Copyright © 2024</p>
            <p class="font-extrabold" style="font-size: 15px;">BIRO ADMINISTRASI PIMPINAN - SEKRETARIAT DAERAH SUMATERA BARAT</p>
        </aside>
        <nav>
            <div class="grid grid-flow-col gap-7">
                <a href="https://www.instagram.com" target="_blank">
                    <img src="../../pic/instagram.png" alt="ig" class="h-7 mr-2">
                </a>
                <a href="https://biroadpim.sumbarprov.go.id/" target="_blank">
                    <img src="../../pic/website.png" alt="web" class="h-7 mr-2">
                </a>
                <a href="https://www.facebook.com/bagianmakopim.adpimsumbar?mibextid=ZbWKwL" target="_blank">
                    <img src="../../pic/facebook.png" alt="fb" class="h-7 mr-2">
                </a>
            </div>
        </nav>
    </footer>
</div>
