<h1>Drag &amp; Drop из RichEdit</h1>
<div class="date">01.01.2007</div>


<pre>
var
   Form1: TForm1;
   richcopy: string;
   transfering: boolean;
 implementation
 
 {$R *.DFM\}
 
 procedure TForm1.RichEdit1MouseDown(Sender: TObject; Button: TMouseButton;
   Shift: TShiftState; X, Y: Integer);
 begin
  if length(richedit1.seltext)&gt;0 then begin
   richcopy:=richedit1.seltext;
   transfering:=true;
  end; //seltext
 end;
 
 procedure TForm1.ListBox1MouseMove(Sender: TObject; Shift: TShiftState; X,
   Y: Integer);
 begin
  if transfering then begin
   transfering:=false;
   listbox1.items.add(richcopy);
  end; //transfering
 end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
