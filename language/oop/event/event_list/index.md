---
Title: Как получить список всех назначенных событий?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как получить список всех назначенных событий?
=============================================

    uses TypInfo;
     
    { .... }
     
    procedure TForm1.Button1Click(Sender: TObject);
    var 
      x, y, z: Word;
      pl: PPropList;
    begin
      y := GetPropList(Self, pl);
      for x := 0 to y - 1 do
      begin
        if Copy(pl[x].Name, 1, 2) <> 'On' then Continue;
        if GetMethodProp(Self, pl[x].Name).Code <> nil then
          Memo1.Lines.Add(Self.Name + ' - ' + pl[x].Name);
      end;
      for z := 0 to Self.ComponentCount - 1 do
      begin
        y := GetPropList(Self.Components[z], pl);
        for x := 0 to y - 1 do
        begin
          if Copy(pl[x].Name, 1, 2) <> 'On' then Continue;
          if GetMethodProp(Self.Components[z], pl[x].Name).Code <> nil then
            Memo1.Lines.Add(Self.Components[z].Name + ' - ' + pl[x].Name);
        end;
      end;
    end;

