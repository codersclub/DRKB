<h1>Доступ к ScrollBars от TTreeView</h1>
<div class="date">01.01.2007</div>



<pre>
  with treeview do begin
    perform( WM_HSCROLL, SB_LINERIGHT, 0 );
    perform( WM_HSCROLL, SB_ENDSCROLL, 0 );
  end;
</pre>
