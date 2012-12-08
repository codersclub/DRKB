---
Title: Кнопка с многострочным заголовком
Date: 01.01.2007
---


Кнопка с многострочным заголовком
=================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      i: Integer; 
    begin 
      i := GetWindowLong(Button1.Handle, GWL_STYLE); 
      SetWindowLong(Button1.Handle, GWL_STYLE, i or BS_MULTILINE); 
      Button1.Caption := 'Delphi World - ' + #13#10 + 'лучше не бывает!';
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

------------------------------------------------------------------------

Приведу способ, как сделать кнопку с тремя (или более) строчками текста.
Разместите на форме компонент TBitBtn и задайте ему достаточно длинный
заголовок. Не волнуйтесь о том, что такой длинный заголовок
\"раздувает\" кнопку налево и направо. Создайте обраб отчик формы
OnCreate как показано ниже:

    var
      R: TRect;
      N: Integer;
      Buff: array[0..255] of Char;
      ...WITH BitBtn1 do
    begin
      Glyph.Canvas.Font := Self.Font;
      Glyph.Width := Width - 6;
      Glyph.Height := Height - 6;
      R := Bounds(0, 0, Glyph.Width, 0);
      StrPCopy(Buff, Caption);
      Caption := '';
      DrawText(Glyph.Canvas.Handle, Buff, StrLen(Buff), R,
        DT_CENTER or DT_WORDBREAK or DT_CALCRECT);
      OffsetRect(R, (Glyph.Width - R.Right) div 2,
        (Glyph.Height - R.Bottom) div 2);
      DrawText(Glyph.Canvas.Handle, Buff, StrLen(Buff), R,
        DT_CENTER or DT_WORDBREAK);
    end;
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
