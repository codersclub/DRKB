---
Title: Show text progressively as typed with a typewriter (horizontal/vertical)
Date: 01.01.2007
---


Show text progressively as typed with a typewriter (horizontal/vertical)
========================================================================

::: {.date}
01.01.2007
:::

    {
     To make this code to work you would need 2 images,
     one for the horizontal- and another for the vertical text.
    }
     
    // VerticalTypewriter ( <Text>, <Image to write to>, <Time to delay between every chars> )
    procedure VerticalTypewriter(text: string; image: timage; delay: integer);
    var
     x,y,i: integer;
    begin
     image.Canvas.Refresh;
     application.ProcessMessages;
     y := 1;
     
     for i := 1 to length(text) do begin
      application.ProcessMessages;
      y := y+image.Canvas.TextHeight(text[i]);
      x := image.width div 2 - (image.Canvas.TextWidth(text[i]) div 2);
      image.Canvas.TextOut(x,y,text[i]);
      sleep(delay);
     end;
     
    end;
     
    // Horizontal Typewriter ( <Text>, <Image to write to>, <Time to delay between every chars>, <Space between chars>)
    procedure HorizontalTypewriter(text: string; image: timage; delay, space: integer);
    var
     x,y,i: integer;
    begin
     image.Canvas.Refresh;
     application.ProcessMessages;
     x := 1;
     
     for i := 1 to length(text) do begin
      application.ProcessMessages;
      y := image.Picture.Height div 2 - (image.Canvas.TextHeight(text[i]) div 2);
      x := x+image.Canvas.TextWidth(text[i])+space;
      image.Canvas.TextOut(x,y,text[i]);
      sleep(delay);
     end;
     
    end;
     
     
    // Sample calls:
    procedure TForm1.Button1Click(Sender: TObject);
    begin
     //                  <text>          <image>  <delay>
     VerticalTypewriter('HELLO BIG-X',   image1,  100     );
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
     //                    <text>         <image>  <delay>  <space>
     HorizontalTypewriter('Hello Big-X',  image2,  100,     1       );
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
