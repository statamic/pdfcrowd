# PDFcrowd

> Generate and download PDFs based on HTML and CSS using [PDFcrowd][pdfcrowd].

## Setup

- Sign up for [PDFcrowd][pdfcrowd].
- Install the addon by copying the contents of this repo to `site/addons/Pdfcrowd`.
- Create a `site/settings/addons/pdfcrowd.yaml` file and add your username and API key:
  ```
  username: username_here
  api_key: api_key_here
  ```

## Usage

Design your PDF using HTML and CSS then use the `pdfcrowd:generate` tag to generate the PDF.

### Generate tag

Generate and download a PDF from a URL.  You can use a `url` parameter of a single tag or place the URL between a tag pair.

```
{{ pdfcrowd:generate url="/url/of/page/to/pdf" }}
```

```
{{ pdfcrowd:generate }}
    /url/of/page/to/pdf
{{ /pdfcrowd:generate }}
```

_Note: This tag will trigger a download of the PDF. The actual template will not be rendered. For example, you'll
probaly want to do something like `<a href="/url/of/page/containing/pdfcrowd/tag">Download PDF</a>`._

## Configuration
You may configure the settings for your PDFs by adding items to your `site/addons/pdfcrowd.yaml` file.

All the settings are available inside `default.yaml`. Simply copy the settings you wish to adjust
into your `pdfcrowd.yaml` file, and modify them.

[pdfcrowd]: http://pdfcrowd.com/
