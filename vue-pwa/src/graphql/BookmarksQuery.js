import gql from 'graphql-tag'

export default gql`
  query {
    bookmarks {
      total
      offset
      limit
      edges {
        id
        title
        url
      }
    }
  }
`
