---
Title: Как работать с GIF-файлами?
Author: МММ
Date: 01.01.2007
---


Как работать с GIF-файлами?
===========================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Этот код, делает следующее:
загружаем в листбох список Gif файлов, затем
это все дело обьединяетсяв один BMP файл,картинка к картинке, кто знает
DirectX поймет для чего это надо (спрайты)

    procedure TForm1.Button2Click(Sender: TObject);
    begin
      if opendialog1.Execute then
      begin
        ListBox1.Items := opendialog1.Files;
        Edit2.Text := inttostr(ListBox1.Items.Count);
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      i, a: integer;
      bm: TBItmap;
    begin
      a := 0;
      bm := TBItmap.Create;
      image1.Picture.LoadFromFile(listbox1.Items[0]);
      bm.Height := image1.Height;
      bm.Width := listbox1.Items.Count * image1.Picture.width;
      for i := 0 to listbox1.Items.Count - 1 do
      begin
        image1.Picture.LoadFromFile(listbox1.Items[i]);
        bm.Canvas.Draw(a, 0, image1.Picture.Graphic);
        a := a + image1.Picture.Height;
      end;
      //form1.Canvas.Draw(0,0,bm);
      bm.SaveToFile(Edit1.Text + '.bmp');
      bm.free;
    end;



------------------------------------------------------------------------

Вариант 2:

Author: МММ

Source: Vingrad.ru <https://forum.vingrad.ru>

> нужна программка, которая вытаскивает из анимированных GIF файлов
> каждую картинку в отдельности, или записывает в отдельный BMP по очереди.

Для этих программок нужен всеми любимый RX Lib !!!

    procedure TForm1.Button4Click(Sender: TObject);
    var
      i, a: integer;
      bm: TBItmap;
    begin
      a := 0;
      bm := TBItmap.Create;
      bm.Height := RxGIFAnimator1.Height;
      bm.Width := RxGIFAnimator1.Image.Count * RxGIFAnimator1.width;
      for i := 0 to RxGIFAnimator1.Image.Count - 1 do
      begin
        RxGIFAnimator1.FrameIndex := i;
        bm.Canvas.Draw(a, 0, RxGIFAnimator1.Image.Frames[i].Bitmap);
        a := a + RxGIFAnimator1.Height;
      end;
      //form1.Canvas.Draw(0,0,bm);
      bm.SaveToFile(Edit1.Text + '.bmp');
      bm.free;
    end;

