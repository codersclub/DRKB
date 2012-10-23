<h1>Если прозрачная часть glyph'а становится видной</h1>
<div class="date">01.01.2007</div>


<p>В некоторых видео режимах прозрачная часть glyph'а стандартного TBitBtn становится видной. Как этого избежать?</p>

<p>В примере используется техника закраски прозрачной части glyph'а цветом кнопки на которой он находится - таким образом glyph кажется прозрачным.</p>

<pre>
function InitStdBitBtn(BitBtn: TBitBtn; kind: TBitBtnKind): bool;
var
  Bm1: TBitmap;
  Bm2: TBitmap;
begin
  Result := false;
  if Kind = bkCustom then
    exit;
  Bm1 := TBitmap.Create;
  case Kind of
    bkOK: Bm1.Handle := LoadBitmap(hInstance, 'BBOK');
    bkCancel: Bm1.Handle := LoadBitmap(hInstance, 'BBCANCEL');
    bkHelp: Bm1.Handle := LoadBitmap(hInstance, 'BBHELP');
    bkYes: Bm1.Handle := LoadBitmap(hInstance, 'BBYES');
    bkNo: Bm1.Handle := LoadBitmap(hInstance, 'BBNO');
    bkClose: Bm1.Handle := LoadBitmap(hInstance, 'BBCLOSE');
    bkAbort: Bm1.Handle := LoadBitmap(hInstance, 'BBABORT');
    bkRetry: Bm1.Handle := LoadBitmap(hInstance, 'BBRETRY');
    bkIgnore: Bm1.Handle := LoadBitmap(hInstance, 'BBIGNORE');
    bkAll: Bm1.Handle := LoadBitmap(hInstance, 'BBALL');
  end;
  Bm2 := TBitmap.Create;
  Bm2.Width := Bm1.Width;
  Bm2.Height := Bm1.Height;
  Bm2.Canvas.Brush.Color := ClBtnFace;
  Bm2.Canvas.BrushCopy(Rect(0, 0, bm2.Width, bm2.Height), Bm1,
    Rect(0, 0, Bm1.width, Bm1.Height),
    Bm1.canvas.pixels[0, 0]);
  Bm1.Free;
  LockWindowUpdate(BitBtn.Parent.Handle);
  BitBtn.Kind := kind;
  BitBtn.Glyph.Assign(bm2);
  LockWindowUpdate(0);
  Bm2.Free;
  Result := true;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  InitStdBitBtn(BitBtn1, bkOk);
end;
</pre>


