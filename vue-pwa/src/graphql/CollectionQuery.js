import gql from 'graphql-tag'

export default gql`
  query Collection($id: Int!, $offset: Int!, $limit: Int!) {
    collection(id: $id) {
      id
      title
      bookmarks(offset: $offset, limit: $limit) {
        total
        edges {
          id
          title
          url
        }
      }
    }
  }
`
