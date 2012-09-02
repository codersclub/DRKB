<h1>Ускорить удаление элементов из TListView</h1>
<div class="date">01.01.2007</div>


<pre>
procedure AddNewListViewItems;
 var
   oldViewStyle: TViewStyle;
 begin
   odlViewStyle := ListView1.ViewStyle;
   ListView1.ViewStyle := vsList;
   ListView1.Items.Clear;
   { Add new Listitems here }
   { An dieser werden die neuen ListItems eingefugt }
   ListView1.ViewStyle := oldViewStyle;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
