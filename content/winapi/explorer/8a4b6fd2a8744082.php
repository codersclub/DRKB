<h1>Как перезагрузить Explorer?</h1>
<div class="date">01.01.2007</div>


<p>HWND hwndShell;</p>
<p>hwndShell = FindWindow ("Progman", NULL);</p>
<p>PostMessage (hwndShell, WM_QUIT, 0, 0L);</p>
<p>ShellExecute (0, "open", "Explorer", NULL, NULL, SW_SHOWNORMAL);</p>
