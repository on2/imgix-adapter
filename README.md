# imgix Adapter

Adapter from home-grown image manipulation to [imgix](https://www.imgix.com/).

The script responds to requests to legacy URLs, generates an imgix URL to process the image then
caches the retrieved image locally.

## Example

A request to:

```
http://imgix-adapter.example/path/to/script/public/c100x50/uploaded-images/myimage.jpg
```

Retrieves an image from:

```
http://imgix-domain.imgix.net/uploaded-images/myimage.jpg?fit=crop&w=100&h=50
```

And caches the image locally at:

```
/path/to/script/public/c100x50/uploaded-images/myimage.jpg
```

Where:

- `c` defines the [resize fit mode](https://www.imgix.com/docs/reference/size#param-fit) and is
  either `c` for `crop` or `r` for `clip`
- `100` is the output width
- `50` is the output height
- `uploaded-images/myimage.jpg` is the path to the image

In addition, `trim=color` is used to trim the edges of the image. You MUST also provide a sign key
which is used to secure the image request.
