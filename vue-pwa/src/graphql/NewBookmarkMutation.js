import gql from 'graphql-tag'

export default gql`
  mutation($title: String!, $url: String!, $collectionId: Int!) {
    createBookmark(title: $title, url: $url, collectionId: $collectionId) {
      id
      title
      url
    }
  }
`
