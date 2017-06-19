import gql from 'graphql-tag'

export default gql`
  mutation($id: Int!) {
    removeBookmark(id: $id)
  }
`
