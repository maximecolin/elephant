import gql from 'graphql-tag'

export default gql`
  mutation($title: String!) {
    createCollection(title: $title) {
      id
      title
      bookmarks {
        total
      }
    }
  }
`
