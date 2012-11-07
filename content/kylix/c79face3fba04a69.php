<h1>Как посмотреть требуемые библиотеки для бинарника?</h1>
<div class="date">01.01.2007</div>


<p>[root@snoppy hello]# ldd helloworld</p>
<p>   /lib/libNoVersion.so.1 =&gt; /lib/libNoVersion.so.1 (0x40018000)</p>
<p>   libpthread.so.0 =&gt; /lib/i686/libpthread.so.0 (0x4002f000)</p>
<p>   libdl.so.2 =&gt; /lib/lib/libdl.so.2 (0x40044000)</p>
<p>   libc.so.6 =&gt; /lib/i686/libc.so.6 (0x40048000)</p>
<p>   /lib/ld-linux.so.2 =&gt; /lib/ld-linux.so.2 (0x40000000)</p>

