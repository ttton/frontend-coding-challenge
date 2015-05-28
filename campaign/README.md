# Coding Challenge Submission

Submission by **Trungtin Ton**

## Technology Stack

- Languages: CSS/HTML/JS
- Frameworks/templates:
    - CSS reset 2.0 by Eric Meyer (http://meyerweb.com/eric/tools/css/reset/)
- Testing frameworks/tools:
    - Markup Validation Service https://validator.w3.org/
    - CSS Validation Service http://jigsaw.w3.org/css-validator/
    - Litmus.com email testing service https://litmus.com
- Build tools/pre-compilers:
    - https://putsmail.com/inliner (CSS inliner for HTML emails)
- IDE/Editor: NetBeans/Atom
- SCM: GitHub (Git)

Note: JavaScript has not been used due to the lack of features requiring it.

## Directory Structure

Webpage content is contained in the `page` subdirectory. The main webpage
is called `index.html`. External sources are located under the `static`
subdirectory. CSS files are located in `css`, while images are stored in
`img`.

```
.
+-- page
    +-- index.html
    +-- static
        +-- css
        +-- img
```

EDM content is stored in the `edm` subdirectory and consists of just 2 files,
`index.html` and the plaintext fallback `index.txt`.

```
.
+-- edm
    +-- index.html
    +-- index.txt
```

## Development Assumptions

- Both the EDM and webpage need to follow exactly the same design
- Static content management (i.e. content does not need to be generated dynamically, thus no application code required)
- Placeholder links are appropriate until proper links are provided
- No graphic resources will be made available besides the screenshot in the assets dir
- Content required for accessibility (e.g. title tag, title attributes and alt tags) that isn't specified in the requirements can be adapted from the provided text
- WC3 standards compliance is required
- UTF-8 encoding allowed
- JavaScript not expressly required (if HTML and CSS are sufficient)
- Links to preview videos can be pointed to relevant pages on the Stan website

## Known Issues

- Low quality raster graphics due to being taken from provided screenshot
- EDM still displays inconsistently across a number of clients, notably:
    - Lotus Notes
    - Outlook (2000, 2002, 2010, 2013)
- EDM doesn't render CSS button stylings. CSS buttons need an image fallback
- CSS "whitesmoke" background color does not render properly on most mail clients (appears white)
- Footer links don't go anywhere
- Button in the "Better Call Saul" mast banner image becomes unreadable at small widths due to image resizing
