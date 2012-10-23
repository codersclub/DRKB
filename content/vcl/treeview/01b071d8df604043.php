<h1>Как убрать всплывающие подсказки в TreeView?</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  If you have installed the Internet Explorer 4.0 or high, in TTreeView component 
  always displaying a hint for cutted items. It's useful but sometimes prevents and 
  irritates (at least, me). But there is a simple way to switch off this feature: 
}
 
 procedure TForm1.FormShow(Sender: TObject);
 const
   TVS_NOTOOLTIPS = $0080;
 begin
   SetWindowLong(Treeview1.Handle, GWL_STYLE,
     GetWindowLong(TreeView1.Handle, GWL_STYLE) xor TVS_NOTOOLTIPS);
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

<hr />
<div class="author">Автор: Eugene Mayevski </div>
<p>TCustomTreeView.WMNotify. О том, что такое тип notify'а TTM_NEEDTEXT пpочтешь в хелпе. Убpать хинты можно, пеpекpыв обpаботчик для этого уведомительного сообщения.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
