<h1>Обмен значениями элементов TListView</h1>
<div class="date">01.01.2007</div>

Today I want to describe how you may exchange some items in standard TListView.</p>
<p>For example, you have 5 items and want to swap</p>
<p>positions for first and third items</p>
<p>Problem that standard TListView component haven''t</p>
<p>such method and you must realize it yourself.</p>
<p>We remember that the standard way from old Pascal times (for numbers) is:</p>
<pre>
 procedure Swap(X, Y: Integer);
 var
   s: Integer;
 begin
   s := X;
   X := Y;
   Y := X
 end;
</pre>
<p>Something similar we can do with TListItem too.</p>
<p>But just to save all strings (caption+sub items) somewhere is not enough because TListItem class have a lot of other information (image indexes, pointer as Data, etc)</p>
<p>So correct way is to use Assign method:</p>
<pre>
 procedure ExchangeItems(lv: TListView; const i, j: Integer);
 var
   tempLI: TListItem;
 begin
   lv.Items.BeginUpdate;
   try
     tempLI := TListItem.Create(lv.Items);
     tempLI.Assign(lv.Items.Item[i]);
     lv.Items.Item[i].Assign(lv.Items.Item[j]);
     lv.Items.Item[j].Assign(tempLI);
     tempLI.Free;
   finally
     lv.Items.EndUpdate
   end;
 end;
</pre>
<p>So structure is a same as in our sample for Integer. All what we added are</p>
<p>BeginUpdate and EndUpdate (just allow to reduce a flickering)</p>
<p>So if you want to exchange items in any ListView, just call this procedure... </p>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
