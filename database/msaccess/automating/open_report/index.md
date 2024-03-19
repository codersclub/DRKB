---
Title: Как открыть отчет?
Date: 01.01.2007
---


Как открыть отчет?
====================

    Access.DoCmd.OpenReport('Titles by Author',
                            acViewPreview, EmptyParam, EmptyParam);

    {
    const
       acViewNormal = $00000000;
       acViewDesign = $00000001;
       acViewPreview = $00000002;
    }
