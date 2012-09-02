<h1>Спрятать горизонтальную или вертикальную полосу прокрутки в TListView</h1>
<div class="date">01.01.2007</div>


<pre>
type
   TForm1 = class(TForm)
     ListView1: TListView;
     procedure FormCreate(Sender: TObject);
     procedure FormDestroy(Sender: TObject);
   private
     FListViewWndProc: TWndMethod;
     procedure ListViewWndProc(var Msg: TMessage);
   public
    { Private declarations }
     FShowHoriz: Boolean;
     FShowVert: Boolean;
   end;
 
    var
   Form1: TForm1;
 
 implementation
 
 {$R *.dfm}
 
 procedure TForm1.ListViewWndProc(var Msg: TMessage);
 begin
   ShowScrollBar(ListView1.Handle, SB_HORZ, FShowHoriz);
   ShowScrollBar(ListView1.Handle, SB_VERT, FShowVert);
   FListViewWndProc(Msg); // process message 
end;
 
 procedure TForm1.FormCreate(Sender: TObject);
 begin
   FShowHoriz := True; // show the horiz scrollbar 
  FShowVert := False; // hide vert scrollbar 
  FListViewWndProc := ListView1.WindowProc; // save old window proc 
  ListView1.WindowProc := ListViewWndProc; // subclass 
end;
 
 procedure TForm1.FormDestroy(Sender: TObject);
 begin
   ListView1.WindowProc := FListViewWndProc; // restore window proc 
  FListViewWndProc := nil;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
