---
Title: Как сравнить две иконки?
Date: 01.01.2007
---

Как сравнить две иконки?
========================

::: {.date}
01.01.2007
:::

    function IconsAreEqual(const Icon1, Icon2: TIcon): Boolean;
     var
       ms1: TMemoryStream;
       ms2: TMemoryStream;
     begin
       Result := False;
       ms1    := TMemoryStream.Create;
       try
         Icon1.SaveToStream(ms1);
         ms2 := TMemoryStream.Create;
         try
           Icon2.SaveToStream(ms2);
           if ms1.Size = ms2.Size then
             // Compare the streams, Streams vergleichen: 
            Result := CompareMem(ms1.Memory, ms2.Memory, ms1.Size)
           finally
             ms2.Free
         end
       finally
         ms1.Free
       end
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     var
       icon1: TIcon;
       icon2: TIcon;
     begin
       icon1 := TIcon.Create;
       icon2 := TIcon.Create;
       try
         icon1.LoadFromFile('c:\Icon1.ico');
         icon2.LoadFromFile('c:\Icon2.ico');
         if IconsAreEqual(icon1, icon2) then
           ShowMessage('Icon 1 and Icon 2 match')
         else
           ShowMessage('Icon 1 and Icon 2 do not match');
       finally
         icon1.Free;
         icon2.Free;
       end;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
