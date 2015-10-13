# imgix Adapter

Adapter from home-grown image manipulation to [imgix](https://www.imgix.com/).

The script responds to requests to legacy URLs and redirects them to an imgix URL.

## Example

A request to:

```
http://imgix-adapter.example/path/to/script/c100x50/uploaded-images/myimage.jpg
```

Redirects to:

```
http://imgix-domain.imgix.net/uploaded-images/myimage.jpg?fit=crop&w=100&h=50
```

Where:

- `c` defines the [resize fit mode](https://www.imgix.com/docs/reference/size#param-fit) and is
  either `c` for `crop` or `r` for `clip`
- `100` is the output width
- `50` is the output height
- `uploaded-images/myimage.jpg` is the path to the image

In addition, `trim=color` is used to trim the edges of the image. You MUST also provide a sign key
which is used to secure the image request.
