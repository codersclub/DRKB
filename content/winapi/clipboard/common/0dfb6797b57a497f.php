<h1>Симулировать нажатие клавиш для копии и вставки из буфера</h1>
<div class="date">01.01.2007</div>


<pre>
//Ctrl+C, Strg+C: 
 
keybd_event(VK_CONTROL, MapVirtualKey(VK_CONTROL, 0), 0, 0);
 keybd_event(Ord('C'), MapVirtualKey(Ord('C'), 0), 0, 0);
 keybd_event(Ord('C'), MapVirtualKey(Ord('C'), 0), KEYEVENTF_KEYUP, 0);
 keybd_event(VK_CONTROL, MapVirtualKey(VK_CONTROL, 0), KEYEVENTF_KEYUP, 0)
 
 
 
 //Ctrl+V, Strg+V: 
 
keybd_event(VK_CONTROL, MapVirtualKey(VK_CONTROL, 0), 0, 0);
 keybd_event(Ord('V'), MapVirtualKey(Ord('V'), 0), 0, 0);
 keybd_event(Ord('V'), MapVirtualKey(Ord('V'), 0), KEYEVENTF_KEYUP, 0);
 keybd_event(VK_CONTROL, MapVirtualKey(VK_CONTROL, 0), KEYEVENTF_KEYUP, 0)
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
