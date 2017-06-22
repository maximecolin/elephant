import gql from 'graphql-tag'

export default gql`
  mutation($id: Int!, $title: String!, $url: String!, $collectionId: Int!) {
    updateBookmark(id: $id, title: $title, url: $url, collectionId: $collectionId) {
      id
      title
      url
    }
  }
`
