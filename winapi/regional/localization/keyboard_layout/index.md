---
Title: Список установленных раскладок клавиатуры
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---

Список установленных раскладок клавиатуры
=========================================

    procedure GetKLList(List: TStrings);
     var
       AList : array [0..9] of Hkl;
       AklName: array [0..255] of Char;
       i: Longint;
     begin
       List.Clear;
       for i := 0 to GetKeyboardLayoutList(SizeOf(AList), AList) - 1 do
         begin
           GetLocaleInfo(LoWord(AList[i]), LOCALE_SLANGUAGE, AklName, SizeOf(AklName));
           List.AddObject(AklName, Pointer(AList[i]));
         end;
     end;
     
     procedure TForm1.FormCreate(Sender: TObject);
     begin
       GetKLList(ListBox1.Items);
     end;
     
     procedure TForm1.ListBox1Click(Sender: TObject);
     begin
       with Sender as TListBox do
         ActivateKeyboardLayout(Hkl(Items.Objects[ItemIndex]), 0);
     end;

