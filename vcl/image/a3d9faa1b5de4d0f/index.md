---
Title: Перемещение иконок между несколькими TImageList
Date: 01.01.2007
---


Перемещение иконок между несколькими TImageList
===============================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
     var
       ico: TIcon;
     begin
       ico := TIcon.Create;
       try
         Imagelist1.GetIcon(0, ico); // Get first icon from Imagelist1 
         Imagelist2.AddIcon(ico); // Add the icon to Imagelist2 
      finally
         ico.Free;
       end;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
