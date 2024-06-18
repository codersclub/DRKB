---
Title: Как создать disabled битмап из обычного (emboss)?
Date: 01.01.2007
---


Как создать disabled битмап из обычного (emboss)?
=================================================

Вариант 1:

Author: Serge Zakharchuk, (2:5060/32)

`CreateMappedBitmap()` :-)

Один из паpаметpов yказатель на COLORMAP, в нем для 16 основных цветов
делаешь пеpекодиpовкy, цвета подбеpешь сам из пpинципа:

- все самые яpкие -\> в GetSysColor( COLOR\_3DLIGHT );
- самые  темные -\> GetSysColor( COLOR\_3DSHADOW );
- нейтpальные, котpые бyдyт пpозpачные -\> GetSysColor( COLOR\_3DFACE );


------------------------------------------------------------------------

Вариант 2:

Author: Denis Tanayeff (denis@demo.ru)

    procedure Tform1.aaa(bmpFrom,bmpTo:Tbitmap); 
    var 
      TmpImage,Monobmp:TBitmap; 
      IRect:TRect; 
    begin 
      MonoBmp := TBitmap.Create; 
      TmpImage:=Tbitmap.Create; 
      TmpImage.Width := bmpFrom.Width; 
      TmpImage.Height := bmpFrom.Height; 
      IRect := Rect(0, 0, bmpFrom.Width, bmpFrom.Height); 
      TmpImage.Canvas.Brush.Color := clBtnFace; 
      try 
        with MonoBmp do 
        begin 
          Assign(bmpFrom); 
          Canvas.Brush.Color := clBlack; 
          if Monochrome then 
     
          begin 
            Canvas.Font.Color := clWhite; 
            Monochrome := False; 
            Canvas.Brush.Color := clWhite; 
          end; 
          Monochrome := True; 
        end; 
        with TmpImage.Canvas do 
        begin 
          Brush.Color := clBtnFace; 
          FillRect(IRect); 
          Brush.Color := clBlack; 
          Font.Color := clWhite; 
          CopyMode := MergePaint; 
          Draw(IRect.Left + 1, IRect.Top + 1, MonoBmp); 
          CopyMode := SrcAnd; 
          Draw(IRect.Left, IRect.Top, MonoBmp); 
     
          Brush.Color := clBtnShadow; 
          Font.Color := clBlack; 
          CopyMode := SrcPaint; 
          Draw(IRect.Left, IRect.Top, MonoBmp); 
          CopyMode := SrcCopy; 
          bmpTo.assign(TmpImage); 
          TmpImage.free; 
        end; 
      finally 
        MonoBmp.Free; 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      aaa(image1.picture.bitmap,image2.picture.bitmap); 
      Image2.invalidate; 
    end; 

Писал это не я. Это написал сам Борланд (некузявно было бы взглянуть на
класс TButtonGlyph.  Как раз из него я это и выдернул).

Hу а если уже совсем хорошо разобраться, то можно заметить  функцию
ImageList\_DrawEx, в которой можно на 25 и 50 процентов уменьшить
яркость (но визуально это очень плохо воспринимается). Соответственно
параметры ILD\_BLEND25, ILD\_BLEND50, ILD\_BLEND-A-MED. Естественно, что
последний абзац работает только с тройкой.


------------------------------------------------------------------------
Вариант 3:

Author: Andy Nikishin (2:5031/16.2)

Это кусочек из рабочей проги на Си, Вроде все лишнее я убрал.

    #define CO_GRAY         0x00C0C0C0L 
     
    hMemDC      =       CreateCompatibleDC(hDC); 
    hOldBitmap  =   SelectObject(hMemDC, hBits); 
     
    //  hBits это собственно картинка, которую надо "засерить" 
     
    GetObject(hBits, sizeof(Bitmap), (LPSTR) &Bitmap); 
     
    if ( GetState(BS_DISABLED) ) // Blt disabled 
    { 
        hOldBrush = SelectObject(hDC, CreateSolidBrush(CO_GRAY));//CO_GRAY 
     
        PatBlt(hDC, BD_BORDERWIDTH, BD_BORDERWIDTH, Bitmap.bmWidth, 
               Bitmap.bmHeight, PATCOPY); 
     
        DeleteObject(SelectObject(hDC, hOldBrush)); 
     
        lbLogBrush.lbStyle = BS_PATTERN; 
        lbLogBrush.lbHatch =(int)LoadBitmap(hInsts, MAKEINTRESOURCE(BT_DISABLEBITS)); 
        hOldBrush = SelectObject(hDC, CreateBrushIndirect(&lbLogBrush)); 
     
        BitBlt(hDC, BD_BORDERWIDTH, BD_BORDERWIDTH, Bitmap.bmWidth, 
                    Bitmap.bmHeight, hMemDC, 0, 0, 0x00A803A9UL); // DPSoa 
     
        DeleteObject(SelectObject(hDC, hOldBrush)); 
        DeleteObject((HGDIOBJ)lbLogBrush.lbHatch); 
     
    } 

Andy Nikishin (2:5031/16.2)

https://www.gs.ru/\~links/andy.shtml

------------------------------------------------------------------------

Вариант 4:

Source: <https://www.swissdelphicenter.ch>

    procedure Emboss(ABitmap : TBitmap; AMount : Integer);
     var
       x, y, i : integer;
       p1, p2: PByteArray;
     begin
       for i := 0 to AMount do
       begin
         for y := 0 to ABitmap.Height-2 do
         begin
           p1 := ABitmap.ScanLine[y];
           p2 := ABitmap.ScanLine[y+1];
           for x := 0 to ABitmap.Width do
           begin
             p1[x*3] := (p1[x*3]+(p2[(x+3)*3] xor $FF)) shr 1;
             p1[x*3+1] := (p1[x*3+1]+(p2[(x+3)*3+1] xor $FF)) shr 1;
             p1[x*3+2] := (p1[x*3+1]+(p2[(x+3)*3+1] xor $FF)) shr 1;
           end;
         end;
       end;
     end;

