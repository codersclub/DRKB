---
Title: Получить текст элемента перечисляемого типа
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Получить текст элемента перечисляемого типа
===========================================

    // For example, if you have some enum type
    // Als Beispiel, wenn dieser Aufzahlungstyp vorhanden ist
     
    {....} 
     
    type 
      TYourEnumType = (One, Two, Three, Four, Five, Six, Seven, Eight, Nine, Ten); 
     
    {....} 
     
    { 
     And you want in run-time to get a string with same value for each of 
     them (for example, fill the Listbox items with enum values), then you 
     can use the next procedure: 
    } 
     
    uses TypInfo; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      i: Integer; 
    begin 
      for i := Ord(Low(TYourEnumType)) to Ord(High(TYourEnumType)) do 
        ListBox1.Items.Add(GetEnumName(TypeInfo(TYourEnumType), i)); 
    end;
     

