[Documentation](../../README.md) / Http Message Converter

## Introduction

The `HttpMessage` converts a PSR-7 HTTP Messages to string, object or array.

Supported interfaces;
- UriInterface
- MessageInterface
- RequestInterface
- ServerRequestInterface
- ResponseInterface

## Using the converter

```php
$converter = new HttpMessage();

// Convert defining type
$converter->canTransform($request, Type::STRING); // -> bool
$converter->transform($request, Type::STRING); // -> string output

// Force type conversion
$converter = new HttpMessage(Type::OBJECT);
$converter->canTransform($request); // -> bool
$converter->transform($request); // -> object output
```


## Type conversion examples

If type is not specified, the converter return an Object.

| Input | Type: Array | Type: Object | Type: String |
|-|-|-|-|
| `UriInterface` | `[scheme: "https", …]` |  `{$scheme: "https", …}` | `"https://example.com/path?query=1#fragment"` |
| `MessageInterface` | `[protocolVersion: "1.1", …]` |  `{$protocolVersion: "1.1", …}` | `"HTTP/1.1"` |
| `RequestInterface` | `[protocolVersion: "1.1", …]` |  `{$protocolVersion: "1.1", …}` | `"GET /path?query=1&fragment HTTP/1.1"` |
| `ServerRequestInterface` | `[protocolVersion: "1.1", …]` |  `{$protocolVersion: "1.1", …}` | `"GET /path?query=1&fragment HTTP/1.1"` |
| `ResponseInterface` | `[protocolVersion: "1.1", …]` |  `{$protocolVersion: "1.1", …}` | `"HTTP/1.1 200 OK"` |


## Fields when type is Array or Object

### UriInterface
```
scheme: string
authority: string
userInfo: string
host: string
port: int|null
path: string
query: string
fragment: string
```

### MessageInterface
```
protocolVersion: string
headers: array<string, string|int|null>
body: string
```

### RequestInterface
```
protocolVersion: string
headers: array<string, string|int|null>
body: string
requestTarget: string
method: string
uri: UriInterface
```

### ServerRequestInterface
```
protocolVersion: string
headers: array<string, string|int|null>
body: string
requestTarget: string
method: string
uri: UriInterface
serverParams: array<string, mixed>
cookieParams: array<string, mixed>
queryParams: array<string, mixed>
attributes: array<string, mixed>
```

### ResponseInterface
```
protocolVersion: string
headers: array<string, string|int|null>
body: string
statusCode: int
reasonPhrase: string
```
