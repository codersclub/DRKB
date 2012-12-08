---
Title: TDBNavigator без иконок
Date: 01.01.2007
---


TDBNavigator без иконок
=======================

::: {.date}
01.01.2007
:::

    var
      c: shortint;
      s: string;
    begin
      s := 'A';
      with DBNavigator1 do
        for c := 0 to ControlCount - 1 do
          if Controls[c] is TNavButton then
            with TNavButton(Controls[c]) do
            begin
              ListBox1.Items.Add(Name);
              Glyph := nil;
              Caption := s;
              Inc(s[1]);
            end;
    end;
