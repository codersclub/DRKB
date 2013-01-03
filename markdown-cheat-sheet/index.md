---
Title: Markdown Cheat Sheet
Description: This Markdown cheat sheet provides a quick overview of all the Markdown syntax elements.
---



# Markdown Cheat Sheet

Thanks for visiting [The Markdown Guide](https://www.markdownguide.org)!

This Markdown cheat sheet provides a quick overview of all the Markdown syntax elements. It can’t cover every edge case, so if you need more information about any of these elements, refer to the reference guides for [basic syntax](https://www.markdownguide.org/basic-syntax) and [extended syntax](https://www.markdownguide.org/extended-syntax).

## Basic Syntax

These are the elements outlined in John Gruber’s original design document. All Markdown applications support these elements.


|Element | Markdown Syntax|
|----|----|
| ### Heading | # H1 <br> ## H2 <br> ### H3 |

### Bold

**bold text**

### Italic

*italicized text*

### Blockquote

> blockquote

### Ordered List

1. First item
2. Second item
3. Third item

### Unordered List

- First item
- Second item
- Third item

### Code with a single backtick (\`)

`code`

### Horizontal Rule

---

### Link

[title](https://www.example.com)

### Link target=_blank

[open in new window](https://www.example.com){:target="_blank"}

### Image

![alt text](image.jpg)

## Extended Syntax

These elements extend the basic syntax by adding additional features. Not all Markdown applications support these elements.

### Table

| Syntax | Description |
| ----------- | ----------- |
| Header | Title |
| Paragraph | Text |

### Fenced Code Block (3 backticks)

```
{
  "firstName": "John",
  "lastName": "Smith",
  "age": 25
}
```
### Fenced Code Block (3 backticks + PHP language specified {.php})
**ToDo:** Need to simplify to **\`\`\`php\\n**

``` {.php}
{
  "firstName": "John",
  "lastName": "Smith",
  "age": 25
}
```

### Fenced Code Block (4 spaces)

    {
      "firstName": "John",
      "lastName": "Smith",
      "age": 25
    }

### Footnote

Here's a sentence with a footnote. [^1]

[^1]: This is the footnote.

### Heading ID

### My Great Heading (id=custom-id) {#custom-id}

### Definition List

term
: definition

### Strikethrough

~~The world is flat.~~ using double tilde

<del>The world is flat.</del> using the &lt;del&gt;&lt;/del&gt; tag

### Task List

- [x] Write the press release
- [ ] Update the website
- [ ] Contact the media
