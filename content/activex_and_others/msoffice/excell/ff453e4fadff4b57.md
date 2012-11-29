Как поменять border страницы?
=============================

::: {.date}
01.01.2007
:::

    { ... }
    var
      Rng: OleVariant;
      LeftEdge: Border;
    { ... }
    WS.Range['A5', 'D5'].Borders.Item[xlEdgeTop].Weight := xlThick;
    WS.Range['A5', 'D5'].Borders.Item[xlEdgeTop].Color := clYellow;
    WS.Range['A5', 'D5'].Borders.Item[xlEdgeBottom].Linestyle := xlDouble;
    WS.Range['A5', 'D5'].Borders.Item[xlEdgeBottom].Color := clYellow;
    { ... }
     
    { ... }
    WS.Evaluate('B6, C6, D6, E6, F6').Borders.Item[xlEdgeLeft].Line
    style := xlContinuous;
    Rng := WS.Range['A1', 'A1'];
    Rng.BorderAround(xlContinuous, xlThin, Color := clFuchsia);
    LeftEdge := WS.Range['B2', 'B5'].Borders.Item[xlEdgeLeft];
    LeftEdge.Linestyle := xlContinuous;
    LeftEdge.Weight := 3;
    LeftEdge.Color := clLime;
    { ... }

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
