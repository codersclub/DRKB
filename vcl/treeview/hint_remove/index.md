---
Title: Как убрать всплывающие подсказки в TreeView?
Author: Eugene Mayevski
Date: 01.01.2007
---


Как убрать всплывающие подсказки в TreeView?
============================================

::: {.date}
01.01.2007
:::

    { 
      If you have installed the Internet Explorer 4.0 or high, in TTreeView component 
      always displaying a hint for cutted items. It's useful but sometimes prevents and 
      irritates (at least, me). But there is a simple way to switch off this feature: 
    }
     
     procedure TForm1.FormShow(Sender: TObject);
     const
       TVS_NOTOOLTIPS = $0080;
     begin
       SetWindowLong(Treeview1.Handle, GWL_STYLE,
         GetWindowLong(TreeView1.Handle, GWL_STYLE) xor TVS_NOTOOLTIPS);
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------

Автор: Eugene Mayevski

TCustomTreeView.WMNotify.

О том, что такое тип notify\'а TTM\_NEEDTEXT
пpочтешь в хелпе. Убpать хинты можно, пеpекpыв обpаботчик для этого
уведомительного сообщения.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 
