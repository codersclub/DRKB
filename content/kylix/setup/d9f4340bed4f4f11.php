<h1>Installing Kylix 3 Open Edition on Mandrake 9</h1>
<div class="date">01.01.2007</div>


<p>How can I get Kylix 3 Open Edition installed and running on Mandrake 9?</p>
<p>Open a Super User Terminal, select "Sessions/New Root Midnight Commander" and in "/", create a directory "temp"</p>
<p>Download or copy the file kylix3_open.tar.gz into the "temp" directory you just created.</p>
<p>Check that all necessary programs are installed on your system:</p>
<p>Open kmenu/configuration/packaging/Remove Software or kpackage</p>
<p>Check for installation of the following: </p>
<p>kernel =&gt; 2.2 (mdk9.0 uses 2.4)</p>
<p>libgtk =&gt; 1.2 (mdk 9.0 uses 1.2-1.2.10-29)</p>
<p>libjpeg =&gt; 6.2 (mdk 9.0 uses 6.-66-25)</p>
<p>XIIR6 (XFree86) (mdk uses 4.2.1-3)</p>
<p>XFree86-dev (mdk9.0 uses 4.2.1-3)</p>
<p>glibc-dev (mdk9.0 uses 2.2.5-16)</p>
<p>Once you have verified that you have all of the necessary programs do the following:</p>
<p>In a Super User Terminal do: </p>
<p>cd /temp</p>
<p>tar zxf kylix3_open.tar.gz</p>
<p>In user terminal (NOT as root):</p>
<p>cd /temp/kylix3_open</p>
<p>./setup.sh</p>
<p>In Gui select "I Agree"</p>
<p>Now select "install"</p>
<p>Logout and log back in as same user to get the Borland Kylix entry in the KDE menu</p>
<p>In Borland Kylix 3 menu, select "register now"</p>
<p>In the Gui select "next"</p>
<p>In the Gui select 'Finish"</p>
<p>The Gui disappears and the registration process has completed.</p>
<p>The Kylix Delphi and Kylix C++ IDE's can now be run. </p>

