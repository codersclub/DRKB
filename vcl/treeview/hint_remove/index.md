---
Title: Как убрать всплывающие подсказки в TreeView?
Date: 01.01.2007
---


Как убрать всплывающие подсказки в TreeView?
============================================

Вариант 1:

Source: <https://www.swissdelphicenter.ch>

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


------------------------------------------------------------------------

Вариант 2:

Author: Eugene Mayevski

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Решение - `TCustomTreeView.WMNotify`.

О том, что такое тип notify\'а `TTM_NEEDTEXT`
пpочтешь в хелпе.

Убpать хинты можно, пеpекpыв обpаботчик для этого
уведомительного сообщения.

