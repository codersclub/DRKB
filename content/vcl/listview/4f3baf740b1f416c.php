<h1>Показать TRadioButtons в TListView</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;
 
 interface
 
 uses
   Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
   StdCtrls, ComCtrls;
 
 type
   TMain = class(TForm)
     ListView1: TListView;
     Button1: TButton;
     Button2: TButton;
     procedure FormCreate(Sender : TObject);
     procedure FormDestroy(Sender : TObject);
     procedure Button1Click(Sender : TObject);
     procedure Button2Click(Sender : TObject);
   private
     ListViewRadioList: TList;
     procedure ListViewRadioCreate(List : TListView; R : TRect);
     procedure ListViewRadioClear(List : TListView; Liste : TList);
     procedure ListViewRadioFree(List : TListView; Liste : TList);
     procedure ListViewListSelected(Item : integer; List : TListView);
     procedure ListViewRadioClick(Sender : TObject);
   public
     { Public-Deklarationen }
   end;
 
 var
   Main : TMain;
 
 implementation
 
 {$R *.DFM}
 
 procedure TMain.FormCreate(Sender : TObject);
 begin
   ListViewRadioList := TList.Create;
 end;
 
 procedure TMain.FormDestroy(Sender : TObject);
 begin
   ListViewRadioFree(ListView1, ListViewRadioList);
 end;
 
 procedure TMain.Button1Click(Sender : TObject);
 var
   R : TRect;
   NewColumn : TListColumn;
   ListItem : TListItem;
   I : integer;
 begin
   with ListView1 do
   begin
     ViewStyle := vsReport;
     Align := alLeft;
     RowSelect := True;
     ReadOnly := True;
     ShowColumnHeaders := False;
     NewColumn := Columns.Add;
     NewColumn.Width := 15;
     NewColumn := Columns.Add;
     NewColumn.Width := Width - 15 - 19; // - breite Button - breite vom Scrollbalken 
    Items.BeginUpdate;
 
     for I := 0 to 9 do
     begin
       ListItem := Items.Add;
       R := Items[I].DisplayRect(drBounds);
       R.Left := 1;
       R.Right := Columns[0].Width;
       ListViewRadioCreate(ListView1, R);
       Items[I].Data := TRadioButton(ListViewRadioList[I]);
       ListItem.SubItems.Add('Test' + IntToStr(I));
     end;
     Items.EndUpdate;
   end;
 end;
 
 procedure TMain.Button2Click(Sender : TObject);
 begin
   ListViewRadioClear(ListView1, ListViewRadioList);
 end;
 //------------------------------------------------------------------------------ 
 
procedure TMain.ListViewRadioCreate(List : TListView; R : TRect);
   function NewViewRadio: TRadioButton;
   begin
     Result := TRadioButton.Create(Self);
     Result.Parent := List;
     Result.BoundsRect := R;
     Result.OnClick := ListViewRadioClick;
   end;
 begin
   ListViewRadioList.Add(NewViewRadio);
 end;
 //------------------------------------------------------------------------------ 
 
procedure TMain.ListViewRadioFree(List : TListView; Liste : TList);
 var
   I : integer;
 begin
   if Liste.Count - 1 &lt; 0 then exit;
   for I := 0 to Liste.Count - 1 do TRadioButton(Liste[I]).Free;
   Liste.Free;
 end;
 //------------------------------------------------------------------------------ 
 
procedure TMain.ListViewRadioClear(List : TListView; Liste : TList);
 var
   I : integer;
 begin
   if Liste.Count - 1 &lt; 0 then exit;
   List.Items.BeginUpdate;
   for I := 0 to Liste.Count - 1 do TRadioButton(Liste[I]).Free;
   List.Items.Clear;
   Liste.Clear;
   List.Items.EndUpdate;
 end;
 //------------------------------------------------------------------------------ 
 
procedure TMain.ListViewListSelected(Item : integer; List : TListView);
 begin
   with List do
   begin
     try
       SetFocus;
     except
     end;
     Selected := Items[Item];
     ItemFocused := Selected;
   end;
 end;
 
 //------------------------------------------------------------------------------ 
procedure TMain.ListViewRadioClick(Sender : TObject);
 var
   I : integer;
 begin
   for I := 0 to ListViewRadioList.Count - 1 do
     if TRadioButton(ListViewRadioList[I]).Checked then
     begin
       ListViewListSelected(I, ListView1);
       break;
     end;
 end;
 
 end.
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
