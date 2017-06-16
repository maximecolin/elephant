import gql from 'graphql-tag'

export default gql`
  query {
    collections(offset: 0 limit: 100) {
      edges {
        id
        title
        bookmarks {
          total
        }
      }
    }
  }
`
