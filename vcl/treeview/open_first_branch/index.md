---
Title: Как открыть первую ветвь TreeView?
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как открыть первую ветвь TreeView?
==================================

> Как программным путем открыть первую ветвь и в ней выделить первый
> элемент?

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      TreeView1.Items[0].Expand(False);
      TreeView1.Items[0].Selected:=true;
      TreeView1.SetFocus;
    end;

